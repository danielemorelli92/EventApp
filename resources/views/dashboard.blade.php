@extends('layouts.layout-header-two-columns')


@section('content')
    <div class="main-content-column">
        <section id="suggested_events">
            <div class="section-title">Eventi suggeriti in base ai tuoi gusti</div>
            <div class="events-list">
                @foreach($interesting_events as $interesting_event)
                    <a name="event" class="event-square" href="/event/{{ $interesting_event->id }}">
                        <div class="event-square-image-container">
                            <img class="image-preview" src="/storage/images/{{$interesting_event->getImage()}}" alt="/images/stock.svg">
                        </div>
                        <div class="event-square-title">{{ $interesting_event->title }}</div>
                        <div class="event-square-attributes-group">
                            <div class="event-square-attribute">
                                {{ $interesting_event->city }}
                            </div>
                            <div class="event-square-attribute">
                                {{ substr($interesting_event->starting_time, 0, -3) }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
        <section id="registered_events_future">
            <div class="section-title">Eventi a cui sei registrato</div>

            <div class="events-list">
                @foreach($registered_events_future as $registered_event_future)
                    <a class="event-square" href="/event/{{ $registered_event_future->id }}">
                        <div class="event-square-image-container">
                            <img class="image-preview" src="/storage/images/{{$registered_event_future->getImage()}}"
                                 alt="/images/stock.svg">
                        </div>
                        <div class="event-square-title">{{ $registered_event_future->title }}</div>
                        <div class="event-square-attributes-group">
                            <div class="event-square-attribute">
                                {{ $registered_event_future->city }}
                            </div>
                            <div class="event-square-attribute">
                                {{ substr($registered_event_future->starting_time, 0, -3) }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
        <section id="registered_events_past">
            <div class="section-title">Eventi a cui hai partecipato</div>
            <div class="events-list">
                @foreach($registered_events_past as $registered_event_past)
                    <a class="event-square" href="/event/{{ $registered_event_past->id }}">
                        <div class="event-square-image-container">
                            <img class="image-small" src="/storage/images/{{$registered_event_past->getImage()}}" alt="/images/stock.svg">
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

        <a href="/user/edit">
            <button style="width: 100%; margin-bottom: 4px;">Modifica account</button>
        </a>

        @if (Gate::allows('create-request'))
            <form action="/request" method="get">
                <button style="width: 100%">Richiedi abilitazione</button>
            </form>
        @else
            @if (\Illuminate\Support\Facades\Auth::user()->type == "normale")
                <form action="/request" method="get">
                    <button style="width: 100%" disabled>Abilitazione in approvazione</button>
                </form>
            @endif
        @endif

        <label class="section-title">I tuoi gusti</label>
        <div>

            <form id="preferences" action="/dashboard" method="post">
                @csrf

                @foreach(Auth::user()->tags as $tag)
                    <div style="display: flex; flex-direction: row" class="checkbox-selection-item">
                        <input type="checkbox" class="checkbox-selection-item-checkbox" name="categories[]"
                               value="{{ $tag->id }}"
                               checked onchange="document.getElementById('preferences').submit()">
                        <label class="checkbox-selection-item-label" for="categories[]">{{ $tag->body }}</label>
                    </div>
                @endforeach
                @foreach($tags->diff(Auth::user()->tags) as $tag)
                    <div class="checkbox-selection-item">
                        <input type="checkbox" class="checkbox-selection-item-checkbox" name="categories[]"
                               value="{{ $tag->id }}"
                               onchange="document.getElementById('preferences').submit()">
                        <label class="checkbox-selection-item-label" for="categories[]">{{ $tag->body }}</label><br>
                    </div>
                @endforeach

            </form>

        </div>
    </div>
@endsection
