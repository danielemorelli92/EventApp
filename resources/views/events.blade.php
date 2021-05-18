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
        <div class="section-title">Filtro distanza/data</div>
        <div class="events-parameters-selection-box"></div>
        <div class="section-title">Filtra per interesse</div>
        <div class="categories-selection-box">
        </div>
    </div>
@endsection
