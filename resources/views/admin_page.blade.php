@extends('layouts.layout-header-two-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')

    <script>
        function searchTable() {
            var input, filter, richiesta_found, utente_found, table_richieste, table_utenti, tr_richiesta, tr_utente, th, i, j;
            input = document.getElementById("search");
            filter = input.value.toLowerCase();
            table_richieste = document.getElementById("lista_richieste");
            table_utenti = document.getElementById("lista_utenti");
            tr_richiesta = table_richieste.getElementsByTagName("tr");
            tr_utente = table_utenti.getElementsByTagName("tr");
            //console.log("Siamo nel metodo");
            for (i = 0; i < tr_richiesta.length; i++) {
                if (filter !== "" && filter != null) {
                    th = tr_richiesta[i].getElementsByTagName("th");
                    for (j = 0; j < th.length; j++) {
                        if (th[j].innerHTML.toLowerCase().indexOf(filter) > -1) {
                            richiesta_found = true;
                        }
                    }
                    if (richiesta_found || i === 0) {
                        tr_richiesta[i].style.display = "";
                        richiesta_found = false;
                    } else {
                        tr_richiesta[i].style.display = "none";
                    }
                } else {
                    tr_richiesta[i].style.display = "";
                }
            }
            for (i = 0; i < tr_utente.length; i++) {
                if (filter !== "" && filter != null) {
                    th = tr_utente[i].getElementsByTagName("th");
                    for (j = 0; j < th.length; j++) {
                        if (th[j].innerHTML.toLowerCase().indexOf(filter) > -1) {
                            utente_found = true;
                        }
                    }
                    if (utente_found || i === 0) {
                        tr_utente[i].style.display = "";
                        utente_found = false;
                    } else {
                        tr_utente[i].style.display = "none";
                    }
                } else {
                    tr_utente[i].style.display = "";
                }
            }

        }
    </script>


    <div class="main-content-column">
        <div id="" style="margin-bottom: 8px; display: flex; flex-direction: row; align-content: center">
            <p class="section-title" style="margin-left: 12px; margin-right: auto">Lista richieste di
                abilitazione</p>
            <input
                type="search"
                style="margin-top: 4px; margin-bottom: 4px;"
                onkeyup='searchTable()'
                onsearch='searchTable()'
                id="search"
                name="search"
                class="filters-item"
                placeholder="Ricerca testuale">
        </div>

        <table id='lista_richieste' style="width:100%">

            <tr class="table_titles_row" style="height: 48px">
                <th>ID</th>
                <th>Data sottomissione</th>
                <th>Nome richiedente</th>
                <th>Cognome richiedente</th>
                <th>Stato</th>
            </tr>

            @foreach($pending_requests as $request)
                <tr class="table_data_row" style="height: 40px">
                    <th>{{$request->id}}</th>
                    <th>{{$request->created_at}}</th>
                    <th>{{$request->nome}}</th>
                    <th>{{$request->cognome}}</th>
                    <th>Pending</th>
                    <td style="display: flex; flex-direction: row">
                        <button type="submit" style="height:36px; margin-left: auto; margin-right: 4px">Accetta</button>
                        <button type="submit" style="height:36px; margin-right: auto;" >Rifiuta</button>
                    </td>
                </tr>
            @endforeach

            @foreach($closed_requests as $request)
                <tr class="table_data_row" style="height: 40px">
                    <th>{{$request->id}}</th>
                    <th>{{$request->created_at}}</th>
                    <th>{{$request->nome}}</th>
                    <th>{{$request->cognome}}</th>
                    <th>Closed</th>
                </tr>
            @endforeach
        </table>



        <table id='lista_utenti' hidden style="width:100%">

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
                    <th><a href="/user-profile/{{$user->id}}">
                            {{$user->id}}</a></th>
                    <th><a href="/user-profile/{{$user->id}}">{{$user->email}}</a></th>
                    <th><a href="/user-profile/{{$user->id}}">
                            {{$user->type}}
                        </a></th>
                    <th><a href="/user-profile/{{$user->id}}">
                            {{$user->name}}
                        </a></th>
                    <th><a href="/user-profile/{{$user->id}}">{{$user->birthday}}</a></th>
                    <th><a href="/user-profile/{{$user->id}}">{{$user->numero_telefono}}</a></th>
                    <th><a href="/user-profile/{{$user->id}}">{{$user->sito_web}}</a></th>
                </tr>
            @endforeach
        </table>

    </div>

    <div class="right-side-column">

        <div class="section-title" >Sezioni</div>
        <div class="radio-selection-item">
            <input id='radio1' class="radio-selection-item-radio" type="radio" name="view" checked
                   onclick="document.getElementById('lista_richieste').removeAttribute('hidden');
                document.getElementById('lista_utenti').setAttribute('hidden', 'hidden')">
            <label for="radio1" class="radio-selection-item-label">
                Richieste
            </label>
        </div>

        <div class="radio-selection-item">
            <input id='radio2' class="radio-selection-item-radio" type="radio" name="view"
                   onclick="document.getElementById('lista_utenti').removeAttribute('hidden');
                document.getElementById('lista_richieste').setAttribute('hidden', 'hidden')">
            <label for="radio2" class="radio-selection-item-label">
                Utenti
            </label>
        </div>

    </div>


@endsection
