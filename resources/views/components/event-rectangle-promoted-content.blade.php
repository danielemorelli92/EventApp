<div class="event-rectangle-image-container">
    <img class="image-preview" src="/storage/images/{{$event->getImage()}}" alt="/images/stock.svg">
</div>
<div class="event-rectangle-title">{{ $event->title }}</div>

@if($event->offer != null)
    <div class="event-rectangle-promo-attribute">
        In sconto del {{ (100 - $event->offer->discount) }}%!
    </div>
@endif
<div class="event-rectangle-attributes-group">
    <div class="event-rectangle-attribute">
        {{ $event->city }}
    </div>
    <div class="event-rectangle-attribute" style="min-width: fit-content;">
        {{ substr($event->starting_time, 0, -3) }}
    </div>
    @if ($event->author_id == \Illuminate\Support\Facades\Auth::id())
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
    @else

    @endif
</div>
