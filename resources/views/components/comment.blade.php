<li>
    <div>
        <p><strong>
                @if( $comment->author->id != $event->author->id )
                    {{ $comment->author->name }}
                @else
                    L'<u>ORGANIZZATORE</u>
                @endif
            </strong> scrive:</p>
        <textarea name="" id="" cols="100" readonly>{{ $comment->content }}</textarea>
        <div style="color: blue; "
             onclick="
                 document.getElementById('response_{{$comment->id}}').hidden = false;
                 document.getElementById('content-area_{{$comment->id}}').focus();"
        >Rispondi
        </div>
        <form id="response_{{$comment->id}}" action="/comment/{{$event->id}}/{{$comment->id}}" method="POST" hidden
              onfocusout="
                            document.getElementById('response_{{$comment->id}}').hidden = true;
                            ">
            <textarea cols="100" rows="3" name="content" id="content-area_{{$comment->id}}"></textarea>
            <input id="rispondi" type="submit" value="INVIA">
        </form>
    </div>
    @foreach($comment->comments as $comment)
        <ul style="list-style-type: none;">
            @include('components.comment')
        </ul>
    @endforeach
</li>
