<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{

    public function init()
    {
        return $this->index(Carbon::now()->year, Carbon::now()->month);
    }

    public function index(int $year, int $month)
    {
        if (!Auth::check()) {
            abort(401);
        }

        $date = Carbon::create($year, $month, 1);
        $first_day = Carbon::create($year, $month, 1)->firstOfMonth();
        $last_day = Carbon::create($year, $month, 1)->lastOfMonth()->addDay()->subSecond();


        while (!$date->isMonday()) {
            $date = $date->subDay();
        }

        $events = Auth::user()->registeredEvents->filter(function ($event) use ($last_day, $first_day) {
            if ($event->ending_time == null || $event->ending_time == "") {
                return $event->start_between($first_day, $last_day);
            } else {
                return $event->happening_between($first_day, $last_day);
            }
        });

        return view('calendar', [
            'date' => $date,
            'month' => $month,
            'year' => $year,
            'events' => $events
        ]);

    }
}
