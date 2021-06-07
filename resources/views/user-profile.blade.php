@extends('layouts.layout-header-two-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')

    <div class="main-content-column">

        <section id="organized_events">
            <div class="section-title">Eventi organizzati</div>

        </section>

        <section id="registered_events_past">
            <div class="section-title">Eventi a cui ha partecipato</div>
            <div class="events-list">
                @foreach($registered_events_past as $registered_event_past)
                    <a class="event-square" href="/event/{{ $registered_event_past->id }}">
                        <div class="event-square-image-container">
                            <img class="image-small" src="{{ $registered_event_past->getImage() }}" alt="image-stock">
                        </div>
                        <div class="event-square-title">{{ $registered_event_past->title }}</div>
                        <div class="event-square-attributes-group">
                            <div class="event-square-attribute">
                                {{ $registered_event_past->address }}
                            </div>
                            <div class="event-square-attribute">
                                {{ substr($registered_event_past->starting_time, 0, -3) }}

                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    </div>

    <div class="right-side-column">
        <div class="section-title">Informazioni utente</div>
        <div class="info-box">

            @if ($user->email != null)
                <label class="info-item-title">Email</label>
                <label class="info-item-label">{{$user->email}}</label>
            @endif
            @if ($user->name != null)
                <label class="info-item-title">Nome</label>
                <label class="info-item-label">{{ $user->name }}</label>
            @endif
            @if ($user->birthday != null)
                <label class="info-item-title">Data di nascita</label>
                <label class="info-item-label">{{ $user->birthday }}</label>
            @endif
            @if ($user->numero_telefono != null)
                <label class="info-item-title">Numero di telefono</label>
                <label class="info-item-label">{{ $user->numero_telefono }}</label>
            @endif
            @if ($user->sito_web != null)
                <label class="info-item-title">Sito web</label>
                <label class="info-item-label">{{ $user->sito_web }}</label>
            @endif

            <textarea>

            </textarea>

        </div>
@endsection
