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


        $events = collect();

        if (count($param) > 0) {
            $query = Event::query();
            if (array_key_exists('search', $param) and !blank($param['search'])) {
                $query = $query->where('title', 'like', '%' . $param['search'] . '%');
                $query = $query->orWhere('description', 'like', '%' . $param['search'] . '%');
                $events = $events->merge($query->get());
            }
            /*if (array_key_exists('luogo', $param) and !blank($param['luogo'])) {
                //$query->where('address', 'like', $param['luogo']);
            }*/
            if (array_key_exists('categories', $param)) {
                foreach ($param['categories'] as $cat_id) {
                    $tag = Tag::query()->where('id', '=', $cat_id)->firstOrFail();
                    $events = $events->merge($tag->events);
                }
            }
            /*if (!blank($param['dist-max'])) {
                $filters[] = ['']
            }
            if(array_key_exists('data-max', $param) and !blank($param['data-max'])) {


                switch($param['data-max']) {
                    case 'today':
                        $now = date(now());
                        $tomorrow = date(now()->setHour(23)->setMinute(59)->setSecond(59));
                        $query->whereDate('starting_time', '>=', $now);
                        //$query->whereDate('starting_time', '<=', $tomorrow);
                        dd($query->get()->push($now));
                        break;
                    case 'tomorrow':
                        $filters[] = ['starting_time', '>=', 'CONCAT(DATE(DATE_ADD(NOW(), INTERVAL 1 DAY), \'23:59:59)\''];
                        break;
                    case 'week':
                        $filters[] = ['starting_time', '<=', 'DATE_ADD(NOW(), INTERVAL 1 WEEK'];
                        break;
                    case 'month':
                        $filters[] = ['starting_time', '<=', 'DATE_ADD(NOW(), INTERVAL 1 MONTH'];
                        break;
                    default:
                        break;
                }
            }*/
        } else {
            $events = Event::all();
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
        $query = Event::query()->where('starting_time', '>=', date(now()));
        $events = $query->get();
        $registered_events = [];

        if (Auth::check()) {
            foreach ($events as $event) {
                if ($event->users->contains(Auth::user())) {
                    $registered_events[] = $event;
                }
            }
        }

        return view('dashboard', [
            'registered_events' => $registered_events
        ]);

    }
}
