@extends('layouts.layout-header-two-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')

    <div class="main-content-column">
        <div id="" class="section-title" style="margin-left: 12px">
            Lista richieste di abilitazione
            <form method="get" action="/admin_page" class="" >
                <input
                    name="search"
                    class="filters-item"
                    type="search"
                    placeholder="Ricerca testuale"
                    value="{{ request('search') }}">
                <button type="submit" value="CERCA">Cerca</button>
            </form>
        </div>

        <table id='lista_richieste' style="width:100%">

            <tr>
                <th>ID</th>
                <th>Data sottomissione</th>
                <th>Nome richiedente</th>
                <th>Cognome richiedente</th>
                <th>Stato</th>
            </tr>

            @foreach($pending_requests as $request)
                <tr>
                    <th>{{$request->id}}</th>
                    <th>{{$request->created_at}}</th>
                    <th>{{$request->nome}}</th>
                    <th>{{$request->cognome}}</th>
                    <th>Pending</th>
                    <th>
                        <button class="big-form-submit-button" type="submit">Accetta</button>
                        <button class="big-form-submit-button" type="submit">Rifiuta</button>
                    </th>

                </tr>
            @endforeach

            @foreach($closed_requests as $request)
                <tr>
                    <th>{{$request->id}}</th>
                    <th>{{$request->created_at}}</th>
                    <th>{{$request->nome}}</th>
                    <th>{{$request->cognome}}</th>
                    <th>Closed</th>
                </tr>
            @endforeach
        </table>






 <!--       <div class="section-title" style="margin-left: 12px">
            Lista utenti
            <form method="get" action="/DA VEDEREEEEEEEEEEEEEEEE" class="" >
                <input
                    name="search"
                    class="filters-item"
                    type="search"
                    placeholder="Ricerca testuale"
                    value="{{ request('search') }}">
                <button type="submit" value="CERCA">Cerca</button>
            </form>
        </div>  -->








        <table id='lista_utenti' style="width:100%">

            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Nome</th>
                <th>Data di nascita</th>
                <th>numero di telefono</th>
                <th>Sito web</th>
            </tr>

            @foreach($users as $user)
                <tr>
                    <th>{{$user->id}}</th>
                    <th>{{$user->email}}</th>
                    <th>
                        {{$user->type}}
                    </th>
                    <th> <a href="/user-profile/{{$user->id}}">
                            {{$user->name}}
                        </a>
                    </th>
                    <th>{{$user->birthday}}</th>
                    <th>{{$user->numero_telefono}}</th>
                    <th>{{$user->sito_web}}</th>
                </tr>
            @endforeach
        </table>

    </div>

    <div class="right-side-column">

        <div class="section-title" style="margin-left: 12px">Sezioni:</div>
        <div style="display: flex; flex-direction: row; ">
             <label for="radio1">
                 Richieste
             </label>
             <input id='radio1' type="radio" name="view" checked
             onclick="document.getElementById('lista_richieste').removeAttribute('hidden');
                document.getElementById('lista_utenti').setAttribute('hidden', 'hidden')">
        </div>

        <div style="display: flex; flex-direction: row; ">
            <label for="radio2">
                Utenti
            </label>
            <input id='radio2' type="radio" name="view"
                   onclick="document.getElementById('lista_utenti').removeAttribute('hidden');
                document.getElementById('lista_richieste').setAttribute('hidden', 'hidden')">
        </div>

    </div>


@endsection