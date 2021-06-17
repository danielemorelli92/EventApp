@extends('layouts.layout-header-one-columns')


@section('content')
    <div class="main-content-column">
        <div class="big-form-container">

            <form style="display: flex; flex-direction: column;" action="/user" method="POST">
                @csrf
                @method('PUT')

                <h2 style="margin-bottom: 20px;">Modifica account</h2>

                <div class="big-form-group">

                    <div class="big-form-row">
                        <label class="big-form-label" for="name" >Nome</label>
                        <input class="big-form-compact-field" id="name" name="name" type="text" placeholder="" value="{{ \Illuminate\Support\Facades\Auth::user()->name }}">
                    </div>


                    <div class="big-form-row">
                        <label class="big-form-label" for="email" >Cognome</label>
                        <input id="email" class="big-form-compact-field" name="email" type="email" value="{{ \Illuminate\Support\Facades\Auth::user()->email }}">
                    </div>

                    <div class="big-form-row">
                        <label class="big-form-label" >Data di nascita</label>
                        <input type="date" id="birthday" name="birthday" class="big-form-compact-field" placeholder="">
                    </div>

                    <div class="big-form-row">
                        <label class="big-form-label"  for="numero_telefono">Numero di telefono</label>
                        <input class="big-form-compact-field"  id="numero_telefono" name="numero_telefono" type="tel"
                               value="{{ \Illuminate\Support\Facades\Auth::user()->numero_telefono }}">
                    </div>

                    <div class="big-form-row">
                        <label class="big-form-label" for="name" >Sito web</label>
                        <input class="big-form-compact-field" id="sito_web" name="sito_web" type="text" placeholder="" value="{{ \Illuminate\Support\Facades\Auth::user()->sito_web }}">
                    </div>

                    <button class="big-form-submit-button" type="submit">Invia</button>
                </div>

            </form>

        </div>
    </div>


@endsection
