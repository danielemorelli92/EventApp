@extends('layouts.layout-header-three-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')


    <div class="left-side-column">
        <a href="javascript:history.back()" style="display: flex; align-items: center; height: 32px; flex-direction: row">
            <div style="width: 18px; height: 18px; margin: 4px">
                <img class="image-preview" src="{{ url('/images/close-icon.svg') }}" alt="close-icon">
            </div>
            <div style="height: 32px; margin-top: 12px" class="section-title">chiudi</div>
        </a>
        <div class="section-title">Immagini</div>
        <div class="event-images-list">
            <div class="event-images-item"></div>
        </div>
    </div>

    <div class="main-content-column">
        <div class="title">{{ $event->title }}</div>
        <div class="section-title" style="margin-left: 8px; margin-top: 8px">Descrizione</div>
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
        @if(\Illuminate\Support\Facades\Gate::allows('admin'))
            <form action="/events/edit/{{ $event->id }}" method="GET">
                <input type="submit" value="Modifica">
            </form>
        @endif
        <div class="section-title">Informazioni evento</div>
        <div class="info-box">
            @if ($event->city != null)
                <label class="info-item-title">Città</label>
                <label class="info-item-label">Roseto degli Abruzzi</label>
            @endif
            @if ($event->address != null)
                <label class="info-item-title">Indirizzo</label>
                <label class="info-item-label">{{ $event->address }}</label>
            @endif
            @if ($event->starting_time != null)
                    <label class="info-item-title">Inizio</label>
                    <label class="info-item-label">{{ substr($event->starting_time, 0, -3) }}</label>
                @endif
            @if ($event->starting_time != null && $event->ending_time != null)
                    <label class="info-item-title">Fine</label>
                    <label class="info-item-label">{{ substr($event->ending_time, 0, -3) }}</label>
                @endif
            @if ($event->registeredUsers != null)
                    <label class="info-item-title">Partecipanti</label>
                    <label class="info-item-label">{{ count($event->registeredUsers) }}</label>
                @endif
            @if ($event->max_partecipants != null && $event->registeredUsers != null)
                    <label class="info-item-title">Posti disponibili</label>
                    <label class="info-item-label">{{ $event->max_partecipants - ($event->registeredUsers->count() + ($event->externalRegistrations->count())) }}</label>
                @endif

            @if ($event->author_id != null)
                    <label class="info-item-title">Organizzatore</label>
                    <label class="info-item-label">
                        <a style="color: #0000FF" href="/user-profile/{{ $event->author->id}}">
                           {{ $event->author->name }}
                        </a>
                    </label>
                @endif

            @if ($event->website != null)
                    <a href="{{ $event->website }}" target="_blank" class="info-item-title">Sito web</a>
                    <a href="{{ $event->website }}" target="_blank" class="info-item-label">{{ $event->website }}</a>
                @endif
            @if ($event->ticket_office != null)
                    <a href="{{ $event->ticket_office }}" target="_blank" class="info-item-title">Biglietti</a>
                    <a href="{{ $event->ticket_office }}" target="_blank" class="info-item-label">{{ $event->ticket_office }}</a>
                @endif
            @if ($event->price != null)
                    <label class="info-item-title">Prezzo</label>
                    <label class="info-item-label">{{ $event->price }}€</label>
                @endif
            @if (count($event->tags) > 0)
                    <label class="info-item-title">Categoria principale</label>
                    <label class="info-item-label">{{ $event->tags[0]->body }}</label>
                @endif
            @if ($event->host != null)
                    <label class="info-item-title">Organizzatore</label>
                    <label class="info-item-label">{{ $event->host->name }}</label>
                @endif
        </div>
    @if (Route::has('login'))
        @auth
            @if($event->registeredUsers->contains(Auth::user())) <!-- Controlla se l'utente collegato è registrato all'evento -->
                <!-- onClick usa JavaScript, andrebbe prima comunicata al server
                      la registrazione dell'utente, poi il refresh che già c'è -->
                <form action="/delete-registration" method="post">
                    @csrf
                    <button type="submit" name="event" value="{{ $event->id }}"
                            style="width: 100%">Annulla registrazione
                    </button>
                </form>

                @else
                    <form action="/registration" method="post">
                        @csrf
                        <button type="submit" name="event" value="{{ $event->id }}"
                                style="width: 100%">Registrati
                        </button>
                    </form>

            @endif
        @endauth
        @guest
            <!-- non sei loggato-->
                <!-- onsubmit usa JavaScript, andrebbe prima comunicata al server
                      la registrazione dell'utente, poi il refresh che già c'è -->
                <form method="post" action="/registration" class="not-registered-user-info-form"
                      style="margin-bottom: 8px; display: flex; flex-direction: column; width: 100%">
                    @csrf
                    <input style="margin-bottom: 4px; width: 100%" name="cf" type="text"
                           placeholder="Codice fiscale" required>
                    <button type="submit" name="event" value="{{ $event->id }}"
                            style="width: 100%">Registrati
                    </button>
                </form>
        @endguest
    @endif

    <!--<button>Aggiungi al calendario</button>-->

    </div>
    </div>
@endsection
