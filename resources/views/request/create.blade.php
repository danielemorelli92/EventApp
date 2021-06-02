@extends('layouts.layout-header-one-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')
    <div class="main-content-column">
        <div class="request-events-administration-form-container" style="margin-left: auto; margin-right: auto;">
            <form style="display: flex; flex-direction: column;" method="post" action="/request">
                @csrf

                <h2 style="margin-bottom: 20px;">Richiesta abilitazione creazione eventi</h2>

                <div class="form-group">
                    <div class="form-row">
                        <label style="margin-left: 3px; margin-right: auto; font-size: 19px">Nome</label>
                        <input style="width: 300px" type="text" placeholder="" name="nome">
                    </div>

                    <div class="form-row">
                        <label style="margin-left: 3px; margin-right: auto; font-size: 19px">Cognome</label>
                        <input style="width: 300px" type="text" placeholder="" name="cognome">
                    </div>

                    <div class="form-row">
                        <label style="margin-left: 3px; margin-right: auto; font-size: 19px">Data di nascita</label>
                        <input style="width: 300px" type="date" placeholder="" name="data_nascita">
                    </div>

                    <div class="form-row">
                        <label style="margin-left: 3px; margin-right: auto; font-size: 19px">Codice documento</label>
                        <input style="width: 300px" type="text" placeholder="" name="codice_documento">
                    </div>

                    <div class="form-row">
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
