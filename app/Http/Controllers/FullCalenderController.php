<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FullCalenderController extends Controller
{

    public function init()
    {
        return $this->index(\Illuminate\Support\Carbon::now()->year, \Illuminate\Support\Carbon::now()->month);
    }

    public function index(int $year, int $month)
    {
        $date = \Illuminate\Support\Carbon::create($year, $month, 1);

        while (!$date->isMonday()) {
            $date = $date->subDay();
        }

        $events = \App\Models\User::find(24)->registeredEvents;

        ddd($events);

        return view('fullcalender', [
            'date' => $date,
            'month' => $month,
            'year' => $year,
            'events' => $events
        ]);

    }
}
