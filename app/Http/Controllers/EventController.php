<?php

namespace App\Http\Controllers;

use App\Models\{Event, Tag};

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        $param = request()->request->all();
        foreach ($param as $key => $value) {
            if (blank($value)) {
                unset($param[$key]);
            }
        }


        $events = Event::all()->where('starting_time', '>=', date(now()));

        if (count($param) > 0) {
            $query = Event::query();
            if (array_key_exists('search', $param) and !blank($param['search'])) {
                $query = $query->where('title', 'like', '%' . $param['search'] . '%');
                $query = $query->orWhere('description', 'like', '%' . $param['search'] . '%');
                $events = $events->intersect($query->get());
            }
            /*if (array_key_exists('luogo', $param) and !blank($param['luogo'])) {
                //$query->where('address', 'like', $param['luogo']);
            }*/
            if (array_key_exists('categories', $param)) {
                $events_with_tags = collect();
                foreach ($param['categories'] as $cat_id) {
                    $tag = Tag::query()->where('id', '=', $cat_id)->firstOrFail();
                    $events_with_tags = $events_with_tags->union($tag->events);
                }
                $events = $events->intersect($events_with_tags);
            }
            if (array_key_exists('dist-max', $param) && !blank($param['dist-max'])) {
                $events_future_in_distance = collect();
                $events_future = Event::query()->get();
                foreach ($events_future as $future_event) {
                    if ($future_event->getDistanceToMe() <= $param['dist-max']) {
                        $events_future_in_distance->push($future_event);
                    }
                }
                $events = $events->intersect($events_future_in_distance);
            }


            if (array_key_exists('data-max', $param) and !blank($param['data-max'])) {
                $query = Event::query();

                switch ($param['data-max']) {
                    case 'today':
                        $dateMax = date(now()->setHour(23)->setMinute(59)->setSecond(59));
                        $query = $query->where('starting_time', '<=', $dateMax);
                        break;
                    case 'tomorrow':
                        $dateMax = date(now()->addDay()->setHour(23)->setMinute(59)->setSecond(59));
                        $query = $query->where('starting_time', '<=', $dateMax);
                        break;
                    case 'week':
                        $dateMax = date(now()->addWeek()->setHour(23)->setMinute(59)->setSecond(59));
                        $query = $query->where('starting_time', '<=', $dateMax);
                        break;
                    case 'month':
                        $dateMax = date(now()->addMonth()->setHour(23)->setMinute(59)->setSecond(59));
                        $query = $query->where('starting_time', '<=', $dateMax);
                        break;
                    default:
                        break;
                }
                $events = $events->intersect($query->get());
            }
        }

        return view('events', [
            'events' => $events->unique('id'), //$query->get()
            'tags' => Tag::all()
        ]);
    }

    public function show(Event $event)
    {
        return view('event', [
            'event' => $event
        ]);
    }


    public function dashboard()
    {
        if (request()->method() == 'POST') {
            $param = request()->request->all();

            if (array_key_exists('categories', $param)) {
                $tags = collect($param['categories']);
                Auth::user()->tags()->sync($tags);
            } else {
                Auth::user()->tags()->sync(collect());
            }
        }

        $events_query = Event::query()->where('starting_time', '>=', date(now()));
        $events = $events_query->get();
        $registered_events = collect();

        $tags_query = Tag::all();
        $interesting_tags = collect();
        $interesting_events = collect();
        if (Auth::check()) {
            foreach ($events as $event) {
                if ($event->users->contains(Auth::user())) {
                    $registered_events->push($event);
                }
            }
            foreach ($tags_query as $tag) {
                if ($tag->users->contains(Auth::user())) {
                    $interesting_tags->push($tag);
                }
            }
            foreach ($interesting_tags as $tag) {
                foreach ($tag->events as $tag_event) {
                    if (! $tag_event->users->contains(Auth::user()) && $tag_event->starting_time >= date(now())) {
                        $interesting_events = $interesting_events->push($tag_event);
                    }
                }
            }
        }
        return view('dashboard', [
            'registered_events' => $registered_events->unique('id'),
            'interesting_events' => $interesting_events->unique('id'),
            'tags' => Tag::all()
        ]);

    }

    public function indexHighlighted()
    {
        $query = Event::query()->where('starting_time', '>=', date(now()))->orderBy('starting_time');
        $events = $query->get();
        $events_highlighted = [];

        foreach ($events as $event) {
            if ($event->getDistanceToMe() <= 25) {
                $events_highlighted[] = $event;
            }
        }

        return view('events-highlighted', [
            'events' => $events_highlighted,
        ]);
    }
}
