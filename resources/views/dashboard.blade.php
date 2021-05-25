@extends('layouts.layout-header-two-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')
    <div class="main-content-column">
        <section id="registered_events">
            <div class="section-title">Eventi a cui sei registrato</div>
            <div class="events-list">
                <!-- TODO foreach -->
                <?php
                include resource_path('views\components\event-square.blade.php');
                ?>
            </div>
        </section>
        <div class="section-title">Eventi suggeriti in base ai tuoi gusti</div>
        <div class="events-list">
            <!-- TODO foreach -->
            <?php
            include resource_path('views\components\event-square.blade.php');
            ?>
        </div>
    </div>

    <div class="right-side-column">
        <button style="">Modifica account</button>
        <div class="section-title">I tuoi gusti</div>
        <div class="events-parameters-selection-box"></div>
    </div>
@endsection
