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
        if (Auth::check()) {
            $event->users()->attach(Auth::user());
        } else {
            $registration = ExternalRegistration::create([
                'event_id' => $event->id,
                'cf' => request('cf')
            ]);

        }
        return redirect('/event/' . request('event'));
    }

    public function delete()
    {
        $event = Event::query()->where('id', request('event'))->get()->first();
        if (Auth::check()) {
            $event->users()->detach(Auth::user());
            return redirect('/event/' . request('event'));
        }
    }
}
