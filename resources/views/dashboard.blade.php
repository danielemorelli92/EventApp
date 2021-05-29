@extends('layouts.layout-header-two-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')
    <div class="main-content-column">
        <section id="registered_events">
            <div class="section-title" style="margin-left: 12px">Eventi a cui sei registrato (futuri)</div>
            <div class="events-list">
                @foreach($registered_events as $registered_event)
                    <a class="event-square" href="/event/{{ $registered_event->id }}">
                        <div class="event-square-image-container">
                            <img class="image-preview" src="{{ url('/images/event-stock.jpg') }}" alt="image-stock">
                        </div>
                        <div class="event-square-title">{{ $registered_event->title }}</div>
                        <div class="event-square-attributes-group">
                            <div class="event-square-attribute">
                                {{ substr($registered_event->starting_time, 0, -3) }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
        <section id="suggested_events">
            <div class="section-title" style="margin-left: 12px">Eventi suggeriti in base ai tuoi gusti</div>
            <div class="events-list">
                @foreach($interesting_events as $interesting_event)
                    <a name="event" class="event-square" href="/event/{{ $interesting_event->id }}">
                        <div class="event-square-image-container">
                            <img class="image-preview" src="{{ url('/images/event-stock.jpg') }}" alt="image-stock">
                        </div>
                        <div class="event-square-title">{{ $interesting_event->title }}</div>
                        <div class="event-square-attributes-group">
                            <div class="event-square-attribute">
                                {{ substr($interesting_event->starting_time, 0, -3) }}
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

            <form id="preferences" action="/dashboard" method="post">
                @csrf

                @foreach(Auth::user()->tags as $tag)
                    <div style="display: flex; flex-direction: row" class="checkbox-selection-item">
                        <input type="checkbox" class="checkbox-selection-item-checkbox" name="categories[]" value="{{ $tag->id }}"
                               checked onchange="document.getElementById('preferences').submit()">
                        <label class="checkbox-selection-item-label" for="categories[]">{{ $tag->body }}</label>
                    </div>
                @endforeach
                @foreach($tags->diff(Auth::user()->tags) as $tag)
                    <div class="checkbox-selection-item">
                        <input type="checkbox" class="checkbox-selection-item-checkbox" name="categories[]" value="{{ $tag->id }}"
                               onchange="document.getElementById('preferences').submit()">
                        <label class="checkbox-selection-item-label" for="categories[]">{{ $tag->body }}</label><br>
                    </div>
                @endforeach

            </form>

        </div>
    </div>
@endsection
