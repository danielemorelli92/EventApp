@extends('layouts.layout-header-one-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')
        <div class="main-content-column">
            <div class="section-title">Eventi prossimi</div>
            <div class="events-list">
                <!-- TODO foreach -->
                <?php
                    include resource_path('views\components\event-rectangle.blade.php');
                ?>
            </div>
    </div>
@endsection
