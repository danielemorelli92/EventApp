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

    <form method="get" action="/" class="right-side-column" style="...">
        <input id="submit" type="submit" value="CERCA">
        <input name="ricerca_testuale" class="modulo-ricerca-item" type="text" placeholder="Ricerca testuale" >
        <label class="section-title">Filtro distanza</label>
        <input id="luogo" class="modulo-ricerca-item" type="text" placeholder="Luogo" >
        <input id="distanza-max" class="modulo-ricerca-item" type="text" placeholder="Distanza max" >
        <label class="section-title">Filtro data</label>
        <div>
            <input type="radio" class="radio-filter-item" id="data-max" name="data-max" value="today">
            <label for="data-max">Oggi</label>
        </div>
        <div>
            <input type="radio" class="radio-filter-item" id="data-max" name="data-max" value="tomorrow">
            <label for="data-max">Domani</label>
        </div>
        <div>
            <input type="radio" class="radio-filter-item" id="data-max" name="data-max" value="week">
            <label for="data-max">Questa settimana</label>
        </div>
        <div>
            <input type="radio" class="radio-filter-item" id="data-max" name="data-max" value="month">
            <label for="data-max">Questo mese</label>
        </div>

        <label class="section-title">Filtra per interesse</label>
        <div>
            <input type="checkbox" class="checkbox-filter-item" id="category" name="category" value="a-category">
            <label for="category">Category</label>
        </div>
    </form>


@endsection
