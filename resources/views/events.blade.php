@extends('layouts.layout')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')

    <header>
        <nav>
            <h1>EventApp</h1>
            <div data-role="header" data-position="inline">
                <div class="btn-group">
                    <form method="get" action="URL_PAGINA_WEB">
                       <a><button>Home</button></a>
                    </form>
                    <form method="get" action="URL_PAGINA_WEB">
                        <a><button>Inserire immagini</button></a>
                    </form>
                    <form method="get" action="URL_PAGINA_WEB">
                        <button>Creare bottoni con i CSS</button>
                    </form>
                    <form method="get" action="URL_PAGINA_WEB">
                        <button>Creare forms con i CSS</button>
                    </form>
                    <form method="get" action="URL_PAGINA_WEB">
                        <button style="width:20px">Creare tabelle con i CSS</button></form>
                    <form method="get" action="URL_PAGINA_WEB">
                        <button style="width:20px">Altri elementi con i CSS</button></form>
                </div>
            </div>
        </nav>
    </header>

    <h1>Eventi in base ai filtri</h1>

    <div class="container">
        <div class="toppane">Test Page</div>
        <div class="leftpane">
            <h1>Test Page</h1></div>
        <div class="rightpane">
            <h1>Test Page</h1></div>
    </div>

    <a href="/">Back</a>
@endsection
