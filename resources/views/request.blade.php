@extends('layouts.layout-header-one-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')

    <div class="container-request">
        <form class="" method="post" action="/request" style="">
            @csrf

            <h2>Inviaci la richiesta</h2>

            <div class="form-group">
                <label>Nome</label>
                <input type="text" class="form-control" placeholder="" name="nome">
            </div>

            <div class="form-group">
                <label>Cognome</label>
                <input type="text" class="form-control" placeholder="" name="cognome">
            </div>

            <div class="form-group">
                <label>Data di nascita</label>
                <input type="date" class="form-control" placeholder="" name="data di nascita">
            </div>

            <div class="form-group">
                <label>Codice documento</label>
                <input type="text" class="form-control" placeholder="" name="codice documento">
            </div>

            <div class="form-group">
                <label>Tipo documento</label>  <!-- non deve essere scritto dall'utente -->
                <input type="text" class="form-control" placeholder="" name="tipo documento">
            </div>

            <div class="...">
                <button type="submit">Invia</button>
            </div>

        </form>

    </div>

@endsection
