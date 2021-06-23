@extends('layouts.layout-header-two-columns')


@section('content')
    <div class="main-content-column">
        <section id="suggested_events">
            <div class="section-title">Eventi suggeriti in base ai tuoi gusti</div>
            <div class="events-list">
                @if($interesting_events->count() != 0)
                    @foreach($interesting_events as $event)
                        @include('components.event-square')
                    @endforeach
                @else
                    <div class="placeholder-item">
                        <div class="placeholder-item-text">non ci sono eventi che assecondino i tuoi gusti</div>
                    </div>
                @endif
            </div>
        </section>
        <section id="registered_events_future">
            <div class="section-title">Eventi a cui sei registrato</div>

            <div class="events-list">
                @if($registered_events_future->count() != 0)
                @foreach($registered_events_future as $event)
                    @include('components.event-square')
                @endforeach
                @else
                    <div class="placeholder-item">
                        <div class="placeholder-item-text">non ci sono eventi a cui tu sia registrato</div>
                    </div>
                @endif
            </div>
        </section>
        <section id="registered_events_past">
            <div class="section-title">Eventi a cui hai partecipato</div>
            <div class="events-list">
                @if($registered_events_past->count() != 0)
                @foreach($registered_events_past as $event)
                    @include('components.event-square')
                @endforeach
                @else
                    <div class="placeholder-item">
                        <div class="placeholder-item-text">finora non hai partecipato ad eventi</div>
                    </div>
                @endif
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
