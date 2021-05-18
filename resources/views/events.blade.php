@extends('layouts.layout-header-two-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')
        <div class="main-content-column">
            <div class="section-title">Eventi in base ai filtri</div>
            <div class="events-list">
                <!-- TODO foreach -->
                <?php
                    include resource_path('views\components\event-rectangle.blade.php');
                ?>
            </div>
    </div>

    <div class="right-side-column">

        <div class="section-title">Ricerca per testo</div>
        <form method="post" action="/" class="modulo-ricerca">
            <input id="ricerca_testuale" class="modulo-ricerca-item" type="text" placeholder="Cerca per..." required>
            <input id="submit" type="submit" value="CERCA">
        </form>

        <div class="section-title">Filtro distanza/data</div>
        <div class="events-parameters-selection-box">
            <form method="post" action="/" class="modulo-ricerca" style="margin-top: 4px">
                <input id="luogo" class="modulo-ricerca-item" type="text" placeholder="Luogo" required>
                <input id="distanza_max" class="modulo-ricerca-item" type="text" placeholder="Distanza max" required>
                <input id="submit" type="submit" value="CONFERMA">
            </form>
        </div>

        <div class="section-title">Filtra per interesse</div>
        <div class="categories-selection-box">
        </div>
    </div>
@endsection
