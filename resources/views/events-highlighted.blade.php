@extends('layouts.layout-header-one-columns')


@section('content')
    <div class="main-content-column">
        <div class="section-title" style="margin-left: 12px">Eventi prossimi</div>
        <div class="events-list">
            @foreach($events as $event)
                @if ($event->isInPromo())
                    @include('components.event-rectangle-promoted-container')
                @else
                    @include('components.event-rectangle-container')
                @endif
                @endforeach
            </div>
    </div>
@endsection
