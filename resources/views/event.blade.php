@extends('layouts.layout-header-three-columns')

@section('script')
    <script>
    </script>
@endsection


@section('content')


    <div class="left-side-column">
        <a href="javascript:history.back()"
           style="display: flex; align-items: center; height: 32px; flex-direction: row">
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

        <hr> <!-- Linea orizzontale -->

        <h1>Commenti</h1>
        @if(\Illuminate\Support\Facades\Auth::check())
            <ul style="list-style-type: none; list-style-position: outside;">
                <li>
                    <p>Inizia una discussione:</p>
                    <form action="/comment/{{$event->id}}" method="POST">
                        @csrf
                        <textarea name="content" id="new_comment" cols="100" rows="3"
                                  placeholder="Scrivi un commento..." required></textarea>
                        <br>
                        <input type="submit" value="Invia">
                    </form>
                </li>
            </ul>
        @endif

        <ul style="list-style-type: none">
            @foreach($event->comments->sortDesc() as $comment)
                @if($comment->parent_id == null)
                    @include('components.comment')
                @endif
            @endforeach
        </ul>

    </div>

    <div class="right-side-column">
        @if(\Illuminate\Support\Facades\Gate::allows('admin'))
            <form action="/events/edit/{{ $event->id }}" method="GET">
                <input type="submit" style="width: 100%;" value="Modifica">
            </form>
            <form action="/events/{{$event->id}}" method="POST">
                @csrf
                @method('delete')
                <input type="submit" style="width: 100%; margin-top: 4px" value="Cancella">
            </form>
        @endif
        <div class="section-title">Informazioni evento</div>
        <div class="info-box">
            @if ($event->city != null)
                <label class="info-item-title">Città</label>
                <label class="info-item-label">{{ $event->city }}</label>
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
                <a class="clickable-info-item-container" href="/user-profile/{{ $event->author->id}}">
                    <label class="info-item-title">Organizzatore</label>
                    <label class="info-item-label">
                            {{ $event->author->name }}
                    </label>
                </a>
                @endif

            @if ($event->website != null)
                    <a class="clickable-info-item-container" href="{{ $event->website }}" target="_blank">
                        <label class="info-item-title">Sito web</label>
                        <label class="info-item-label">{{ $event->website }}</label>
                    </a>
                @endif
            @if ($event->ticket_office != null)
                    <a class="clickable-info-item-container" href="{{ $event->ticket_office }}" target="_blank">
                        <label class="info-item-title">Biglietti</label>
                        <label class="info-item-label">{{ $event->ticket_office }}</label>
                    </a>
                @endif
            @if ($event->price != 0)
                    <label class="info-item-title">Prezzo</label>
                    <label class="info-item-label">{{ $event->price }}€</label>
                @else
                      <label class="info-item-title">Prezzo</label>
                      <label class="info-item-label">GRATIS!</label>
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

    @if($event->registration_link == "none")
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
                   @if($event->criteri_accettazione != null)
                        <form action="/accetta/{{ $event->id }}" method="get">
                            @csrf
                            <button type="submit" name="event" value="{{ $event->id }}"
                                    style="width: 100%">Registrati
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
                                style="width: 100%">Registrazione
                        </button>
                    </form>
                    @endguest
                @endif
            @elseif ($event->registration_link == "website")
                <form action="{{$event->website}}" target="_blank">
                    <button type="submit"
                            style="width: 100%">Vai alla registrazione
                    </button>
                </form>
            @elseif ($event->registration_link == "ticket_office")
                <form action="{{$event->ticket_office}}" target="_blank">
                    <button type="submit"
                            style="width: 100%">Vai alla registrazione
                </button>
            </form>
    @endif

    <!--<button>Aggiungi al calendario</button>-->

    </div>
    </div>
@endsection
