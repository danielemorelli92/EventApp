
<a name="event" class="event-rectangle" href="/event/{{ $event->id }}">
    <div class="event-rectangle-image-container">
        <img class="image-preview" src="/storage/images/{{$event->getImage()}}" alt="/images/stock.svg">
    </div>
    <div class="event-rectangle-title">{{ $event->title }}</div>
    <div class="event-rectangle-attributes-group">
        <div class="event-rectangle-attribute">
            {{ $event->city }}
        </div>
        <form action="/events/{{ $event->id }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="icon-button-42">
                <img class="image-preview" src="{{ url('/images/trash-icon.svg') }}" alt="trash-icon">
            </button>
        </form>
        <form action="/events/edit/{{ $event->id }}" method="GET">
            @csrf
            <button class="icon-button-42">
                <img class="image-preview" src="{{ url('/images/pen-icon.svg') }}" alt="pen-icon">
            </button>
        </form>
    </div>
</a>
