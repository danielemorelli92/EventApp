@extends('layouts.layout-header-two-columns')


@section('content')

    <div class="main-content-column">

        <section id="organized_events">
            <div class="section-title">Eventi organizzati</div>
            <div class="events-list">
                @foreach($created_events as $created_event)
                    <a class="event-square" href="/event/{{ $created_event->id }}">
                        <div class="event-square-image-container">
                            <img class="image-preview" src="/storage/images/{{$created_event->getImage()}}" alt="/images/stock.svg">
                        </div>
                        <div class="event-square-title">{{ $created_event->title }}</div>
                        <div class="event-square-attributes-group">
                            <div class="event-square-attribute">
                                {{ $created_event->city }}
                            </div>
                            <div class="event-square-attribute">
                                {{ substr($created_event->starting_time, 0, -3) }}

                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <section id="registered_events_past">
            <div class="section-title">Eventi a cui ha partecipato</div>
            <div class="events-list">
                @foreach($registered_events_past as $registered_event_past)
                    <a class="event-square" href="/event/{{ $registered_event_past->id }}">
                        <div class="event-square-image-container">
                            <img class="image-preview" src="/storage/images/{{$registered_event_past->getImage()}}" alt="/images/stock.svg">
                        </div>
                        <div class="event-square-title">{{ $registered_event_past->title }}</div>
                        <div class="event-square-attributes-group">
                            <div class="event-square-attribute">
                                {{ $registered_event_past->city }}
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
        @if(Illuminate\Support\Facades\Gate::allows('downgrade', $user))
            <form action="/permissions/{{ $user->id }}" method="POST">
                @csrf
                @method('delete')
                <input type="submit" value="Rimuovi permessi">
            </form>
        @endif
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
