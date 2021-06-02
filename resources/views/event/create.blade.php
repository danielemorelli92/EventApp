@extends('layouts.layout-header-one-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')
    <div class="main-content-column">
        <div class="big-form-container">
            <form style="display: flex; flex-direction: column;" method="post" action="/events">
                @csrf
                <h2 style="margin-bottom: 20px;">Informazioni dell'evento</h2>
                <div class="big-form-group">
                    <div class="big-form-column"><label class="big-form-label" for="title">Titolo</label>
                        <input class="big-form-big-field" name="title" type="text" placeholder="..." required></div>
                    <div class="big-form-column"><label class="big-form-label" for="description">Descrizione</label><input class="big-form-big-field" type="text" name="description" placeholder="..." required></div>
                    <div class="big-form-column"><label class="big-form-label" for="address">Indirizzo</label><input class="big-form-big-field" type="text" name="address" required></div>
                    <div class="big-form-row"><label class="big-form-label" for="type">Tipo evento</label><input class="big-form-compact-field" type="text" name="type" required></div>
                    <div class="big-form-row"><label class="big-form-label" for="max_partecipants">Numero partecipanti</label><input class="big-form-compact-field" type="number" min="0" name="max_partecipants" placeholder=""></div>
                    <div class="big-form-row"><label class="big-form-label" for="price">Prezzo</label><input class="big-form-compact-field" type="number" min="0" step="0.01" name="price" placeholder=""></div>
                    <div class="big-form-row"><label class="big-form-label" for="ticket_office">Biglietteria</label><input class="big-form-compact-field" type="text" name="ticket_office"></div>
                    <div class="big-form-row"><label class="big-form-label" for="website">Sito web</label><input class="big-form-compact-field" type="text" name="website"></div>
                    <div class="big-form-row"><label class="big-form-label" for="starting_time">Data inizio evento</label><input class="big-form-compact-field" type="datetime-local" name="starting_time" required></div>
                    <div class="big-form-row"><label class="big-form-label" for="ending_time">Data fine evento</label><input class="big-form-compact-field" type="datetime-local" name="ending_time"></div>

                    <button class="big-form-submit-button" type="submit" value="Crea evento">Crea evento</button>
                </div>
            </form>

        </div>
    </div>


@endsection

