<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ExternalRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventRegistrationController extends Controller
{
    public function create()
    {
        $event = Event::query()->where('id', request('event'))->get()->first();

        if ($event->registration_link == "none") {
            if ($event->max_partecipants == 0 || ($event->registeredUsers->count()) + ($event->externalRegistrations->count()) < $event->max_partecipants) {
                if (Auth::check()) {
                    $event->registeredUsers()->attach(Auth::user());
                } else {
                    ExternalRegistration::create([
                        'event_id' => $event->id,
                        'cf' => request('cf')
                    ]);
                }
            }
        }
        return redirect('/event/' . request('event'));
    }

    public function delete()
    {
        $event = Event::query()->where('id', request('event'))->get()->first();
        if (Auth::check()) {
            $event->registeredUsers()->detach(Auth::user());
            return redirect('/event/' . request('event'));
        }
    }

    public function show(Event $event)
    {
        return view('acceptance-criteria', [
            'event' => $event
        ]);
    }
}
