@extends('layouts.layout-header-one-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')

    <div class="container-request">
        <form class="" method="post" action="/request" style="">
            @csrf
            <h1>Inviaci la richiesta</h1>

            <div class="form-group">
                <label>Codice documento</label>
                <input type="text" class="form-control" placeholder="Codice fiscale" name="nric">
            </div>

            <div class="form-group">
                <label>Nome</label>
                <input type="text" class="form-control" placeholder="Tempo totale" name="tempo" value="">
            </div>

            <div class="form-group" id="inggroup">
                <label>Cognome</label>  <button class="btn-a btn-custom" type="button">+</button>  <button class="btn-b btn-custom" type="button">-</button><br>
                <input type="text" class="form-control" placeholder="Ingrediente" name="ingr1" id="ingr1"><br>
            </div>

            <div class="form-group" id="stepgroup">
                <label>Data di nascita</label>  <button class="btn-a btn-custom" type="button">+</button>  <button class="btn-b btn-custom" type="button">-</button><br>
                <input type="text" class="form-control" placeholder="Step" name="step1" id="step1"><br>
            </div>

            <div class="">
                <button type="submit">Invia</button>
            </div>


        </form>

    </div>

@endsection
