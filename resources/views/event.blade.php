@extends('layouts.layout-header-three-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')


    <div class="left-side-column">
        <div style="display: flex; align-items: center; flex-direction: row">
            <div style="margin-left: 8px; background-color: green; width: 16px; height: 16px"></div>
            <div class="section-title">chiudi</div> <!-- TODO cambiare stile -->
        </div>
        <div class="section-title">Immagini</div>
        <div class="event-images-list">
            <div class="event-images-item"></div>
        </div>
    </div>

    <div class="main-content-column">
        <div class="title">{{ $event->title }}</div>
        <div class="section-title">Descrizione</div>
        <div class="text-area">
            {{ $event->description }}
        </div>
        <div style="width: auto; height: min-content; display: flex; flex-wrap: wrap; margin: 8px">
            @foreach($event->tags as $tag)
            <div class="category-oval">{{ $tag->body }}</div>
            @endforeach
        </div>
    </div>

    <div class="right-side-column">
        <div class="section-title">Informazioni evento</div>
        <div class="event-info-box">

        </div>
        @if (Route::has('login'))
            @auth
                <button style="margin-top: auto">Registrati</button>
            @else
                <form method="get" action="/" class="not-registered-user-info-form"
                      style="margin-top: auto; margin-bottom: 8px; display: flex; flex-direction: column; width: 100%"
                >
                    <input style="margin-left: 8px; margin-right: 8px;"  name="cf-form" type="text" placeholder="Codice fiscale" required>
                    <button style="margin-left: 8px; margin-right: 8px;">Registrati</button>

                </form>
            @endauth
        @endif

        <!--<button>Aggiungi al calendario</button>-->

    </div>
    </div>
@endsection
