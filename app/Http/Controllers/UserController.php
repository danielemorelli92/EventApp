<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function show(User $user)
    {
        $created_events = Event::all()->where('author_id', '=', $user->id);
        $registered_events_past = Event::all()->where('starting_time', '<=', date(now()));
        return view('user-profile', [
            'created_events' => $created_events,
            'registered_events_past' => $registered_events_past,
            'user' => $user
        ]);
    }

    public function downgrade(User $user)
    {
        if (Gate::denies('admin')) {
            abort('401');
        }

        if ($user->type === 'organizzatore') {
            $user->update(['type' => 'normale']);
            $request = \App\Models\Request::all()
                ->where('user_id', $user->id)->first();
            if ($request != null) {
                $request->delete();
            }
        }

        return redirect('/user-profile/' . $user->id);
    }

    public function upgrade(User $user)
    {

        if (Gate::denies('admin')) {
            abort('401');
        }

        if($user->type === 'normale'){
            $user->update(['type' => 'organizzatore']);
        }

        return redirect('/admin_page');
    }
}
