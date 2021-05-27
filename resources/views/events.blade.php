@extends('layouts.layout-header-two-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')
    <div class="main-content-column">
        <div class="section-title">Eventi in base ai filtri</div>
        <div class="events-list">
            @foreach($events as $event)
            <a name="event" class="event-rectangle" href="/event/{{ $event->id }}">
                <div class="event-rectangle-image-container">
                    <img class="image-small" src="{{ url('/images/event-stock.jpg') }}" alt="image-stock">
                </div>
                <div class="event-rectangle-title">{{ $event->title }}</div>
                <div class="event-rectangle-attributes-group">
                    <div class="event-rectangle-attribute">
                        {{ $event->address }}
                    </div>
                    <div class="event-rectangle-attribute">
                        {{ $event->starting_time }}
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <form method="get" action="/events" class="right-side-column" style="...">
        <input type="submit" value="CERCA">
        <input
            name="search"
            class="modulo-ricerca-item"
            type="search"
            placeholder="Ricerca testuale"
            value="{{ request('search') }}"
        >
        <label class="section-title">Filtro distanza</label>
        <input class="modulo-ricerca-item" type="text" name="luogo" placeholder="Luogo">
        <input class="modulo-ricerca-item" type="text" name="dist-max" placeholder="Distanza max">
        <label class="section-title">Filtro data</label>
        <div>
            <input type="radio" class="radio-filter-item" name="data-max" value="today" default>
            <label for="data-max">Oggi</label>
        </div>
        <div>
            <input type="radio" class="radio-filter-item" name="data-max" value="tomorrow">
            <label for="data-max">Domani</label>
        </div>
        <div>
            <input type="radio" class="radio-filter-item" name="data-max" value="week">
            <label for="data-max">Questa settimana</label>
        </div>
        <div>
            <input type="radio" class="radio-filter-item" name="data-max" value="month">
            <label for="data-max">Questo mese</label>
        </div>

        <label class="section-title">Filtra per interesse</label>
        <div>

            @foreach($tags as $tag)
                <input type="checkbox" class="checkbox-filter-item" name="categories[]" value="{{ $tag->id }} ">
                <label for="category">{{ $tag->body }}<br></label>
            @endforeach
        </div>
    </form>


@endsection
