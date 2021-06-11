@extends('layouts.layout-header-three-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')

    <form action="/registration" method="post">
        @csrf

        <div class="">{{ $event->criteri_accettazione }}</div>


        <button type="submit" name="event" value="{{ $event->id }}"
                style="width: 100%">Accetta e registrati
        </button>
    </form>

@endsection
