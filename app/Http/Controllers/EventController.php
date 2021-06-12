<?php

namespace App\Http\Controllers;

use App\Notifications\AddressChanged;
use App\Notifications\DateChanged;
use App\Notifications\DescriptionChanged;
use App\Notifications\EventCanceled;
use App\Notifications\TitleChanged;
use App\Models\{Event, Tag};

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

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

    public function create()
    {
        if (Gate::denies('create-event')) {
            abort(401);
        }

        return view('event.create');
    }

    public function store()
    {
        if (Gate::denies('create-event')) {
            abort(401);
        }

        $validatedData = request()->validate([
            'title' => 'required|string|min:4|max:255',
            'description' => 'required',
            'address' => 'required|string',
            'type' => 'required|string|min:4|max:255',
            'starting_time' => 'required|date',
            'ending_time' => 'nullable|date',
            'max_partecipants' => 'nullable|min:0|max:999999999',
            'price' => 'nullable|min:0|max:9999999',
            'ticket_office' => 'nullable',
            'website' => 'nullable',
            'registration_link' => 'string',
            'criteri_accettazione'=> 'nullable'
        ]);
        if ($validatedData['website'] != "" && !str_contains($validatedData['website'], "http://")  && !str_contains($validatedData['website'], "https://") ) {
            $validatedData['website'] = 'https://'.$validatedData['website'];
        }
        if ($validatedData['ticket_office'] != "" && !str_contains($validatedData['ticket_office'], "http://")  && !str_contains($validatedData['ticket_office'], "https://") ) {
            $validatedData['ticket_office'] = 'https://'.$validatedData['ticket_office'];
        }

        $validatedData['author_id'] = Auth::id();
        if ( ($validatedData['registration_link'] == 'ticket_office' && $validatedData['ticket_office'] == "") ||  ($validatedData['registration_link'] == 'website' && $validatedData['website'] == "") ) {
            abort(400);
        }

        $event = Event::factory()->create($validatedData);

        return redirect('/events/manage', 201);
    }

    public function manage()
    {
        if (!Gate::any(['has-a-event', 'create-event'])) {
            abort(401);
        }

        $param = request()->request->all();
        foreach ($param as $key => $value) {
            if (blank($value)) {
                unset($param[$key]);
            }
        }


        $my_events = Auth::user()->createdEvents;

        $selected_date_filter = 'any';

        if (count($param) > 0) {
            if (array_key_exists('date-filter-selection', $param) and !blank($param['date-filter-selection'])) {
                if ($param['date-filter-selection'] != 'any') {
                    $query = Event::query();
                    switch ($param['date-filter-selection']) {
                        case 'past':
                            $selected_date_filter = 'past';
                            $dateMax = date(now());
                            $query = $query->where('starting_time', '<', $dateMax);
                            break;
                        case 'today':
                            $selected_date_filter='today';
                            $dateMin = date(now()->setHour(0)->setMinute(0)->setSecond(0));
                            $dateMax = date(now()->setHour(23)->setMinute(59)->setSecond(59));
                            $query = $query->whereBetween('starting_time', [$dateMin, $dateMax]);
                            break;
                        case 'tomorrow':
                            $selected_date_filter='tomorrow';
                            $dateMin = date(now()->addDay()->setHour(0)->setMinute(0)->setSecond(0));
                            $dateMax = date(now()->addDay()->setHour(23)->setMinute(59)->setSecond(59));
                            $query = $query->whereBetween('starting_time', [$dateMin, $dateMax]);
                            break;
                        case 'week':
                            $selected_date_filter='week';
                            $dateMin = date(now()->setHour(0)->setMinute(0)->setSecond(0));
                            $dateMax = date(now()->addWeek()->setHour(23)->setMinute(59)->setSecond(59));
                            $query = $query->whereBetween('starting_time', [$dateMin, $dateMax]);
                            break;
                        case 'month':
                            $selected_date_filter='month';
                            $dateMin = date(now()->setHour(0)->setMinute(0)->setSecond(0));
                            $dateMax = date(now()->addMonth()->setHour(23)->setMinute(59)->setSecond(59));
                            $query = $query->whereBetween('starting_time', [$dateMin, $dateMax]);
                            break;
                        default:
                            break;
                    }
                    $my_events = $my_events->intersect($query->get());
                } else {
                    $selected_date_filter='any';
                }
            }
        }

        return view('events-management', [
            'my_events' => $my_events->unique('id'),
            'selected_date_filter' => $selected_date_filter
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

        $events = Event::all();
        $registered_events_future = collect();
        $registered_events_past = collect();

        $tags_query = Tag::all();
        $interesting_tags = collect();
        $interesting_events = collect();
        if (Auth::check()) {
            foreach ($events as $event) {
                if ($event->registeredUsers->contains(Auth::user())) {
                    if ($event->starting_time > date(now())) {
                        $registered_events_future->push($event);
                    } else {
                        $registered_events_past->push($event);
                    }
                }
            }
            foreach ($tags_query as $tag) {
                if ($tag->users->contains(Auth::user())) {
                    $interesting_tags->push($tag);
                }
            }
            foreach ($interesting_tags as $tag) {
                foreach ($tag->events as $tag_event) {

                    if (!$tag_event->registeredUsers->contains(Auth::user()) && $tag_event->starting_time >= date(now())) {
                        $interesting_events = $interesting_events->push($tag_event);
                    }
                }
            }
        }
        return view('dashboard', [
            'registered_events_future' => $registered_events_future->unique('id'),
            'registered_events_past' => $registered_events_past->unique('id'),
            'interesting_events' => $interesting_events->unique('id'),
            'tags' => Tag::all()
        ]);

    }

    public function destroy(Event $event)
    {
        if (!Gate::allows('delete-event', $event)) {
            abort(401);
        }

        $title = $event->title;
        $start = $event->starting_time;
        $address = $event->address;

        $event->delete();

        if (now()->isBefore(new Carbon($start))) { // invia la notifica di cancellazione solo se l'evento non è ancora iniziato
            Notification::send($event->registeredUsers, new EventCanceled($title, $start, $address));
        }

        return redirect('/events/manage');
    }

    public function edit(Event $event)
    {
        if (Gate::denies('edit-event', $event)) {
            abort(401);
        }

        return view('event.edit', [
            'event' => $event
        ]);
    }

    public function update(Event $event)
    {
        if (Gate::denies('edit-event', $event)) {
            abort(401);
        }

        $validatedData = request()->validate([
            'title' => 'string|min:4|max:255',
            'description' => 'string',
            'address' => 'string',
            'type' => 'string|min:4|max:255',
            'starting_time' => 'date',
            'registration_link' => 'string',
            'ending_time' => 'nullable|date',
            'max_partecipants' => 'nullable|min:0|max:999999999',
            'price' => 'nullable|min:0|max:9999999',
            'ticket_office' => 'nullable',
            'website' => 'nullable'
        ]);

        if (array_key_exists('registration_link', $validatedData) && $event->fresh()->registration_link != $validatedData['registration_link']) {
            if (!($validatedData['registration_link'] == 'ticket_office' && (array_key_exists('ticket_office', $validatedData) || $event->ticket_office != null))) {
                abort(400);
            }
            if (!($validatedData['registration_link'] == 'website' && (array_key_exists('website', $validatedData) || $event->website != null))) {
                abort(400);
            }
        }

        $old_title = $event->title;
        $old_descr = $event->description;
        $old_start = $event->starting_time;
        $old_address = $event->address;

        $event->update($validatedData);

        $event->refresh();

        if ($event->title != $old_title) {
            Notification::send($event->registeredUsers, new TitleChanged($event, $old_title));
        }
        if ($event->description != $old_descr) {
            Notification::send($event->registeredUsers, new DescriptionChanged($event, $old_descr));
        }
        if ($event->starting_time != $old_start) {
            Notification::send($event->registeredUsers, new DateChanged($event, $old_start));
        }
        if ($event->address != $old_address) {
            Notification::send($event->registeredUsers, new AddressChanged($event, $old_address));
        }

        return redirect('/events/manage');
    }
}
