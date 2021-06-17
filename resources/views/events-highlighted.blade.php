@extends('layouts.layout-header-one-columns')


@section('content')
    <div class="main-content-column">
        <div class="section-title" style="margin-left: 12px">Eventi prossimi</div>
        <div class="events-list">
            @foreach($events as $event)
                <a name="event" class="event-rectangle" href="/event/{{ $event->id }}">
                    <div class="event-rectangle-image-container">
                        <img class="image-preview" src="{{ $event->getImage() }}"
                             alt="/images/stock.svg">
                    </div>
                    <div class="event-rectangle-title">{{ $event->title }}</div>
                    <div class="event-rectangle-attributes-group">
                        <div class="event-rectangle-attribute">
                            {{ $event->city }}
                        </div>
                        <div class="event-rectangle-attribute" style="min-width: fit-content;">
                            {{ substr($event->starting_time, 0, -3) }}
                        </div>
                    </div>
                    </a>
                @endforeach
            </div>
    </div>
@endsection
