@extends('layouts.layout-header-one-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')
    <div class="main-content-column">
        <div class="big-form-container">

            <form style="display: flex; flex-direction: column;" method="post" action="/request">
                @csrf

                <h2 style="margin-bottom: 20px;">Richiesta abilitazione creazione eventi</h2>

                <div class="big-form-group">
                    <div class="big-form-row">
                        <label class="big-form-label" >Nome</label>
                        <input class="big-form-compact-field" type="text" placeholder="" name="nome">
                    </div>

                    <div class="big-form-row">
                        <label class="big-form-label" >Cognome</label>
                        <input class="big-form-compact-field" type="text" placeholder="" name="cognome">
                    </div>

                    <div class="big-form-row">
                        <label class="big-form-label" >Data di nascita</label>
                        <input class="big-form-compact-field" type="date" placeholder="" name="data_nascita">
                    </div>

                    <div class="big-form-row">
                        <label class="big-form-label" >Codice documento</label>
                        <input class="big-form-compact-field" type="text" placeholder="" name="codice_documento">
                    </div>

                    <div class="big-form-row">
                        <label class="big-form-label" >Tipo documento</label>
                        <select class="big-form-compact-field" name="tipo_documento">
                            <option name="tipo_documento" value="identity card" selected="selected">carta d'identita
                            </option>
                            <option name="tipo_documento" value="driving license">patente</option>
                            <option name="tipo_documento" value="passport">passaporto</option>
                        </select>
                    </div>

                    <button class="big-form-submit-button" type="submit">Invia</button>
                </div>

            </form>

        </div>
    </div>


@endsection
