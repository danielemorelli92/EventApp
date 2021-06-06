@extends('layouts.layout-header-two-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')

    <div class="main-content-column">
        <div class="section-title" style="margin-left: 12px">Lista richieste di abilitazione</div>

        <section id="opened_request">
            <div class="section-title">Richieste aperte</div>

            <div class="requests-list">
                @foreach($registered_events_future as $registered_event_future)
                    <a class="event-square" href="/event/{{ $registered_event_future->id }}">
                        <div class="event-square-title">{{ $registered_event_future->title }}</div>
                        <div class="event-square-attributes-group">
                            <div class="event-square-attribute">
                                {{ $registered_event_future->address }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <section id="accepted_request">
            <div class="section-title">Richieste accettate</div>

            <div class="requests-list">

            </div>
        </section>


    </div>
@endsection
