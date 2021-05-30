@extends('layouts.layout-header-two-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')
    <div class="main-content-column">
        <div class="section-title" style="margin-left: 12px">I miei eventi</div>
        <div class="events-list">
            @foreach($my_events as $event)
            <a name="event" class="event-rectangle" href="/event/{{ $event->id }}">
                <div class="event-rectangle-image-container">
                    <img class="image-preview" src="{{ url('/images/event-stock.jpg') }}" alt="image-stock">
                </div>
                <div class="event-rectangle-title">{{ $event->title }}</div>
                <div class="event-rectangle-attributes-group">
                    <div class="event-rectangle-attribute">
                        {{ $event->address }}
                    </div>
                    <div class="event-rectangle-attribute" style="min-width: fit-content;">
                        {{ substr($event->starting_time, 0, -3) }}
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <form id="preferences" action="/events/manage" class="right-side-column" method="get">
        @csrf
        <label class="section-title">Filtro data</label>
        <div class="radio-selection-item">
            @if($selected_date_filter == '' || $selected_date_filter == 'any')
                <input type="radio" checked onchange="document.getElementById('preferences').submit()" class="radio-selection-item-radio" name="data-max" value="any">
            @else
                <input type="radio" onchange="document.getElementById('preferences').submit()" class="radio-selection-item-radio" name="data-max" value="any">
            @endif
            <label for="data-max" class="radio-selection-item-label" >Qualunque</label>
        </div>
        <div class="radio-selection-item">
            @if($selected_date_filter == 'past')
                <input type="radio" checked onchange="document.getElementById('preferences').submit()" class="radio-selection-item-radio" name="data-max" value="past">
            @else
                <input type="radio" onchange="document.getElementById('preferences').submit()" class="radio-selection-item-radio" name="data-max" value="past">
            @endif
            <label for="data-max" class="radio-selection-item-label" >Passato</label>
        </div>
        <div class="radio-selection-item">
            @if($selected_date_filter == 'today')
                <input type="radio" checked onchange="document.getElementById('preferences').submit()" class="radio-selection-item-radio" name="data-max" value="today">
            @else
                <input type="radio" onchange="document.getElementById('preferences').submit()" class="radio-selection-item-radio" name="data-max" value="today">
            @endif
            <label for="data-max" class="radio-selection-item-label" >Oggi</label>
        </div>
        <div class="radio-selection-item">
            @if($selected_date_filter == 'tomorrow')
                <input type="radio" checked onchange="document.getElementById('preferences').submit()" class="radio-selection-item-radio" name="data-max" value="tomorrow">
            @else
                <input type="radio" onchange="document.getElementById('preferences').submit()" class="radio-selection-item-radio" name="data-max" value="tomorrow">
            @endif
            <label for="data-max" class="radio-selection-item-label" >Domani</label>
        </div>
        <div class="radio-selection-item">
            @if($selected_date_filter == 'week')
                <input type="radio" checked onchange="document.getElementById('preferences').submit()" class="radio-selection-item-radio" name="data-max" value="week">
            @else
                <input type="radio" onchange="document.getElementById('preferences').submit()" class="radio-selection-item-radio" name="data-max" value="week">
            @endif
            <label for="data-max" class="radio-selection-item-label">Questa settimana</label>
        </div>
        <div class="radio-selection-item">
            @if($selected_date_filter == 'month')
                <input type="radio" checked onchange="document.getElementById('preferences').submit()" class="radio-selection-item-radio" name="data-max" value="month">
            @else
                <input type="radio" onchange="document.getElementById('preferences').submit()" class="radio-selection-item-radio" name="data-max" value="month">
            @endif
            <label for="data-max" class="radio-selection-item-label">Questo mese</label>
        </div>
    </form>


@endsection
