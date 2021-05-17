@extends('layouts.layout')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')

    <div class="two-columns-container">
        <div class="main-content-column">Main</div>
        <div class="right-side-column">
            <h1>Right</h1></div>
    </div>


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
