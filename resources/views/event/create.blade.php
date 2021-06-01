<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create event</title>
</head>
<body>
<h1>Creazione evento</h1>
<form style="display: flex; flex-direction: column" action="/events" method="post">
    @csrf
    <label for="title">Titolo</label>
    <input name="title" type="text" placeholder="..." required>
    <label for="description">Descrizione</label>
    <input type="text" name="description" placeholder="..." required>
    <label for="type">Tipo evento</label>
    <input type="text" name="type" required>
    <label for="max_partecipants">Numero partecipanti</label>
    <input type="number" name="max_partecipants" placeholder="">
    <label for="price">Prezzo</label>
    <input type="number" name="price" placeholder="">
    <label for="ticket_office">Biglietteria</label>
    <input type="text" name="ticket_office">
    <label for="website">Sito web</label>
    <input type="text" name="website">
    <label for="address">Indirizzo</label>
    <input type="text" name="address" required>
    <label for="starting_time">Data inizio evento</label>
    <input type="datetime-local" name="starting_time" required>
    <label for="ending_time">Data fine evento</label>
    <input type="datetime-local" name="ending_time">

    <input type="submit" value="Crea evento!">
</form>
</body>
</html>





@extends('layouts.layout-header-one-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')
    <div class="main-content-column">
        <div class="big-form-container" style="margin-left: auto; margin-right: auto;">
            <form style="display: flex; flex-direction: column;" method="post" action="/request">
                @csrf

                <h2 style="margin-bottom: 20px;">Richiesta abilitazione creazione eventi</h2>

                <div class="big-form-group">
                    <div class="big-form-row">
                        <label style="margin-left: 3px; margin-right: auto; font-size: 19px">Nome</label>
                        <input style="width: 300px" type="text" placeholder="" name="nome">
                    </div>

                    <div class="big-form-row">
                        <label style="margin-left: 3px; margin-right: auto; font-size: 19px">Cognome</label>
                        <input style="width: 300px" type="text" placeholder="" name="cognome">
                    </div>

                    <div class="big-form-row">
                        <label style="margin-left: 3px; margin-right: auto; font-size: 19px">Data di nascita</label>
                        <input style="width: 300px" type="date" placeholder="" name="data_nascita">
                    </div>

                    <div class="big-form-row">
                        <label style="margin-left: 3px; margin-right: auto; font-size: 19px">Codice documento</label>
                        <input style="width: 300px" type="text" placeholder="" name="codice_documento">
                    </div>

                    <div class="big-form-row">
                        <label style="margin-left: 3px; margin-right: auto; font-size: 19px">Tipo documento</label>
                        <select style="width: 300px" name="tipo_documento">
                            <option name="tipo_documento" value="identity card" selected="selected">carta d'identita
                            </option>
                            <option name="tipo_documento" value="driving license">patente</option>
                            <option name="tipo_documento" value="passport">passaporto</option>
                        </select>
                    </div>

                    <button style="width: 80px; margin-top: 50px; margin-left: auto" type="submit">Invia</button>
                </div>

            </form>

        </div>
    </div>


@endsection
