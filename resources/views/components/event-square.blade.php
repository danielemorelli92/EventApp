<a id="event-square" class="event-square" href="/event/{{ $event->id }}">
    <div class="event-square-image-container">
        <img class="image-preview" src="/storage/images/{{$event->getImage()}}"
             alt="/images/stock.svg">
    </div>
    <div class="event-square-title">{{ $event->title }}</div>
    <div class="event-square-attributes-group">
        <div class="event-square-attribute">
            {{ substr($event->starting_time, 0, -3) }}
        </div>
    </div>
</a>
