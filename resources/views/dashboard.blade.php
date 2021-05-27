@extends('layouts.layout-header-two-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')
    <div class="main-content-column">
        <section id="registered_events">
            <div class="section-title">Eventi a cui sei registrato (futuri)</div>
            <div class="events-list">
                @foreach($registered_events as $registered_event)
                    <a class="event-square" href="/event/{{ $registered_event->id }}">
                        <div class="event-square-image-container">
                            <img class="image-small" src="{{ url('/images/event-stock.jpg') }}" alt="image-stock">
                        </div>
                        <div class="event-square-title">{{ $registered_event->title }}</div>
                        <div class="event-square-attributes-group">
                            <div class="event-square-attribute">
                                {{ $registered_event->address }}
                            </div>
                            <div class="event-square-attribute">
                                {{ $registered_event->starting_time }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
        <section id="suggested_events">
            <div class="section-title">Eventi suggeriti in base ai tuoi gusti</div>
            <div class="events-list">
                @foreach($interesting_events as $interesting_event)
                    <a name="event" class="event-square" href="/event/{{ $interesting_event->id }}">
                        <div class="event-square-image-container">
                            <img class="image-small" src="{{ url('/images/event-stock.jpg') }}" alt="image-stock">
                        </div>
                        <div class="event-square-title">{{ $interesting_event->title }}</div>
                        <div class="event-square-attributes-group">
                            <div class="event-square-attribute">
                                {{ $interesting_event->address }}
                            </div>
                            <div class="event-square-attribute">
                                {{ $interesting_event->starting_time }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    </div>

    <div class="right-side-column">
        <button style="">Modifica account</button>
        <label class="section-title">I tuoi gusti</label>
        <div>
            @foreach($tags as $tag)
                <form id="preferences" action="/dashboard" method="post">
                    @csrf
                    <input type="checkbox" class="checkbox-filter-item" name="categories[]" value="{{ $tag->id }}"
                           {{Auth::user()->tags->contains($tag->id) ? 'checked' : ''}}
                           onchange="document.getElementById('preferences').submit()">
                    <label for="category">{{ $tag->body }}</label><br>
                </form>
            @endforeach
        </div>
    </div>
@endsection
