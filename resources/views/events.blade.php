@extends('layouts.layout')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')


    <div class="main-content-column">
        <h2>Eventi in base ai filtri</h2>
        <div class="events-list">
            <div class="event-item-rectangle"></div>
            <div class="event-item-rectangle"></div>
            <div class="event-item-rectangle"></div>
            <div class="event-item-rectangle"></div>
            <div class="event-item-rectangle"></div>
            <div class="event-item-rectangle"></div>
            <div class="event-item-rectangle"></div>
            <div class="event-item-rectangle"></div>
            <div class="event-item-rectangle"></div>
            <div class="event-item-rectangle"></div>
            <div class="event-item-rectangle"></div>
            <div class="event-item-rectangle"></div>
        </div>

    </div>
    <div class="right-side-column">
        <h1>Right</h1></div>


    <!--

    <h1>Eventi in base ai filtri</h1>

    <div class="container">
        <div class="toppane">Test Page</div>
        <div class="leftpane">
            <h1>Test Page</h1></div>
        <div class="rightpane">
            <h1>Test Page</h1></div>
    </div>

    <a href="/">Back</a>-->
@endsection
