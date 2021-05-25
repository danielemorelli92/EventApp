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
                    <a name="event" class="event-square" href="/event/{{ $registered_event->id }}">
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
        <div class="section-title">Eventi suggeriti in base ai tuoi gusti</div>
        <div class="events-list">
            <!-- TODO foreach -->
            <?php
            include resource_path('views\components\event-square.blade.php');
            ?>
        </div>
    </div>

    <div class="right-side-column">
        <button style="">Modifica account</button>
        <div class="section-title">I tuoi gusti</div>
        <div class="events-parameters-selection-box"></div>
    </div>
@endsection
