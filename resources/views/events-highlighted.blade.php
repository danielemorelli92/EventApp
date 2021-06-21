@extends('layouts.layout-header-one-columns')


@section('content')
    <div class="main-content-column">
        <div class="section-title" style="margin-left: 12px">Eventi prossimi</div>
        <div class="events-list">
            @foreach($events as $event)
                @include('components.event-rectangle-container')

                @endforeach
            </div>
    </div>
@endsection
