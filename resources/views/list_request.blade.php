@extends('layouts.layout-header-two-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')

    <div class="main-content-column">
        <div class="section-title" style="margin-left: 12px">Lista richieste di abilitazione</div>

        <section id="opened_request">
            <div class="section-title">Richieste aperte</div>

            <div class="requests-list">
                @foreach($pending_requests as $request)


                @endforeach
            </div>
        </section>

        <section id="accepted_request">
            <div class="section-title">Richieste accettate</div>
            @foreach($closed_requests as $request)


            @endforeach

            <div class="requests-list">

            </div>
        </section>


    </div>
@endsection
