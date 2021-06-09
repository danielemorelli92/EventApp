<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //

    public function show(User $user)
    {
        return view('user-profile', [
            'user' => $user
        ]);
    }

    public function user_profile(User $user)
    {
        $created_events = Event::all()->where('author_id', '=', $user->id);
        $registered_events_past = Event::all()->where('starting_time', '<=', date(now()));
            return view('user-profile', [
                'created_events' => $created_events,
                'registered_events_past' => $registered_events_past,
                'user' => $user
            ]);
    }
}
