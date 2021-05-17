@extends('layouts.layout')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')


    <div class="main-content-column">
        <div class="section-title">Eventi in base ai filtri</div>
        <div class="events-list">
            <div class="event-rectangle">
                <div class="event-rectangle-image-container">
                    <!--TODO inserire immagine <img src="imgBOH" alt="BOHBOH">-->
                </div>
                <div class="event-rectangle-title">Event title</div>
                <div class="event-rectangle-attributes-group">
                    <div class="event-rectangle-attribute">
                        Category
                    </div>
                    <div class="event-rectangle-attribute">
                        Place
                    </div>
                    <div class="event-rectangle-attribute">
                        Date
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="right-side-column">
        <div class="section-title">Filtro distanza/data</div>
        <div class="events-filters-selection-box">

        </div>
        <div class="section-title">Interessi</div>
        <div class="interests-selection-box">

        </div>
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
