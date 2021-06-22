@extends('layouts.layout-header-one-columns')


@section('content')
    <div class="main-content-column">
        <div class="section-title" style="margin-left: 12px">Eventi prossimi</div>

        @if($events->count() != 0)
            <div class="events-list">
                @foreach($events as $event)
                    @if ($event->isInPromo())
                        @include('components.event-rectangle-promoted-container')
                    @else
                        @include('components.event-rectangle-container')
                    @endif
                @endforeach
            </div>
        @else
            <div class="placeholder-item"  id='lista_richieste' style="width: auto" >
                <div class="placeholder-item-text">non ci sono eventi in evidenza</div>
            </div>
        @endif
    </div>
@endsection
