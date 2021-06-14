<li>
    <div>
        <p>
            @if( $comment->author->id == \Illuminate\Support\Facades\Auth::id())
                <strong>Tu</strong> hai scritto:
            @elseif( $comment->author->id != $event->author->id )
                <strong>{{ $comment->author->name }}</strong> ha scritto:
            @else
                <strong>L'<u>ORGANIZZATORE</u></strong> ha scritto:
            @endif
        </p>
        <textarea
            style="width: 90%; height: auto;"
            form="update_form_{{ $comment->id }}"
            name="content"
            id="comment_{{ $comment->id }}"
            readonly
            onchange="
                let button = document.getElementById('submit_{{ $comment->id }}');
                if(document.getElementById('comment_{{ $comment->id }}').value !== {{ $comment->content }}) {
                button.hidden = false;
                } else {
                button.hidden = true;
                }
                "
        >{{ $comment->content }}</textarea>
        @if(\Illuminate\Support\Facades\Auth::check())
            @if(\Illuminate\Support\Facades\Auth::id() != $comment->author_id)
                <div style="display: flex; justify-content: space-between; width: 90%">
                    <div style="color: blue;"
                         onclick="
                             document.getElementById('response_{{$comment->id}}').hidden = !document.getElementById('response_{{$comment->id}}').hidden;
                             document.getElementById('content-area_{{$comment->id}}').focus();"
                    >
                        Rispondi
                    </div>
                </div>
                <form
                    id="response_{{$comment->id}}"
                    action="/comment/{{$event->id}}/{{$comment->id}}"
                    method="POST"
                    hidden
                >
                    @csrf
                    <textarea name="content"
                              id="content-area_{{$comment->id}}"
                              style="width: 90%; height: auto;"
                              placeholder="Rispondi al commento..."
                    ></textarea>
                    <input type="submit" value="Invia risposta">
                </form>
            @else
                <div style="display: flex; justify-content: space-between; width: 90%">
                    <div style="display: flex;">
                        <div style="color: blue; "
                             onclick="
                                 let comment_area = document.getElementById('comment_{{ $comment->id }}');
                                 comment_area.removeAttribute('readonly');
                                 document.getElementById('update_form_{{$comment->id}}').hidden = false;
                                 comment_area.focus();
                                 "
                        >
                            Modifica
                        </div>
                        <div>
                            Cancella<!-- QUI CI VA Elimina -->
                        </div>
                    </div>
                    <form id="update_form_{{$comment->id}}" action="/comment/{{$comment->id}}"
                          method="POST"
                          hidden
                          onfocusout="document.getElementById('response_{{$comment->id}}').hidden = true;"
                    >
                        @csrf
                        @method('PUT')

                        <input type="submit" value="Invia">
                    </form>
                    @endif
                    @endif
                </div>
                @foreach($comment->comments as $comment)
                    <ul style="list-style-type: none; list-style-position: outside;">
                        @include('components.comment')
                    </ul>
    @endforeach
</li>
