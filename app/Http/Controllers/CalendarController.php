<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{

    public function init()
    {
        return $this->index(\Illuminate\Support\Carbon::now()->year, \Illuminate\Support\Carbon::now()->month);
    }

    public function index(int $year, int $month)
    {
        if (!Auth::check()) {
            abort(401);
        }

        $date = \Illuminate\Support\Carbon::create($year, $month, 1);

        while (!$date->isMonday()) {
            $date = $date->subDay();
        }

        if (Auth::user()->registeredEvents->isNotEmpty()) {
            $query = Auth::user()->registeredEvents->toQuery()->whereMonth('starting_time', $month)->whereYear('starting_time', $year);
        } else {
            $query = Event::query()->where('id', '=', -1);
        }


        return view('calendar', [
            'date' => $date,
            'month' => $month,
            'year' => $year,
            'query_events' => $query
        ]);

    }
}
