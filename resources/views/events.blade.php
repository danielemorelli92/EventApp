@extends('layouts.layout-header-two-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')
    <div class="main-content-column">
        <div class="section-title" style="margin-left: 12px">Eventi in base ai filtri</div>
        <div class="events-list">
            @foreach($events as $event)
                <a name="event" class="event-rectangle" href="/event/{{ $event->id }}">
                    <div class="event-rectangle-image-container">
                        <img class="image-preview" src="{{ $event->getImage() }}" alt="image-stock">
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

    <form method="get" action="/events" class="right-side-column" >
        <button type="submit" value="CERCA">Cerca</button>
        <input
            name="search"
            class="filters-item"
            type="search"
            placeholder="Ricerca testuale"
            value="{{ request('search') }}"
        >
        <label class="section-title">Filtro distanza</label>
        <input class="filters-item" type="text" name="luogo" placeholder="Luogo" value="Pescara">
        <input class="filters-item" type="text" name="dist-max" placeholder="Distanza max">
        <label class="section-title">Filtro data</label>
        <div class="radio-selection-item">
            <input type="radio" class="radio-selection-item-radio" name="data-max" value="today" default>
            <label for="data-max" class="radio-selection-item-label" >Oggi</label>
        </div>
        <div class="radio-selection-item">
            <input type="radio" class="radio-selection-item-radio" name="data-max" value="tomorrow">
            <label for="data-max" class="radio-selection-item-label" >Domani</label>
        </div>
        <div class="radio-selection-item">
            <input type="radio" class="radio-selection-item-radio" name="data-max" value="week">
            <label for="data-max" class="radio-selection-item-label">Questa settimana</label>
        </div>
        <div class="radio-selection-item">
            <input type="radio" class="radio-selection-item-radio" name="data-max" value="month">
            <label for="data-max" class="radio-selection-item-label">Questo mese</label>
        </div>

        <label class="section-title">Filtra per interesse</label>
        <div>
            @foreach($tags as $tag)
                <div class="checkbox-selection-item">
                    <input type="checkbox" class="checkbox-selection-item-checkbox" name="categories[]" value="{{ $tag->id }} ">
                    <label for="category" class="checkbox-selection-item-label" >{{ $tag->body }}<br></label>
                </div>
            @endforeach
        </div>
    </form>


@endsection
