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
            @if($event->registeredUsers->contains(Auth::user())) <!-- Controlla se l'utente collegato è registrato all'evento -->
                <!-- onClick usa JavaScript, andrebbe prima comunicata al server
                      la registrazione dell'utente, poi il refresh che già c'è -->
                <form action="/delete-registration" method="post">
                    @csrf
                    <button type="submit" name="event" value="{{ $event->id }}"
                            style="margin-top: auto">Annulla registrazione
                    </button>
                </form>

                @else
                    <form action="/registration" method="post">
                        @csrf
                        <button type="submit" name="event" value="{{ $event->id }}"
                                style="margin-top: auto">Registrati
                        </button>
                    </form>

            @endif
        @endauth
        @guest
            <!-- non sei loggato-->
                <!-- onsubmit usa JavaScript, andrebbe prima comunicata al server
                      la registrazione dell'utente, poi il refresh che già c'è -->
                <form method="post" action="/registration" class="not-registered-user-info-form"
                      style="margin-top: auto; margin-bottom: 8px; display: flex; flex-direction: column; width: 100%">
                    @csrf
                    <input style="margin-left: 8px; margin-right: 8px;" name="cf" type="text"
                           placeholder="Codice fiscale" required>
                    <button type="submit" name="event" value="{{ $event->id }}"
                            style="margin-left: 8px; margin-right: 8px;">Registrati
                    </button>
                </form>
        @endguest
    @endif

    <!--<button>Aggiungi al calendario</button>-->

    </div>
    </div>
@endsection
