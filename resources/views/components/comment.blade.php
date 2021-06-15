<li class="comment-container"
    @if ($comment->parent_id == null)
        style="border: 0.0px solid #fff;"
        @endif
>
    <div> <!-- titolo commento -->
        @if( $comment->author->id == \Illuminate\Support\Facades\Auth::id())
            <strong>Tu</strong> hai scritto:
        @elseif( $comment->author->id != $event->author->id )
            <strong>{{ $comment->author->name }}</strong> ha scritto:
        @else
            <strong>L'<u>ORGANIZZATORE</u></strong> ha scritto:
        @endif
    </div>

    <div style="width: auto; display: flex; flex-direction: column;">


    <textarea
        hidden
        disabled
        style="width: auto; resize: none"
        form="update_form_{{ $comment->id }}"
        name="content"
        id="comment_area_{{ $comment->id }}"
        onfocus="auto_grow(this)"
        oninput="auto_grow(this)"
        onchange="
            let button = document.getElementById('submit_{{ $comment->id }}');
            if(document.getElementById('comment_area_{{ $comment->id }}').value !== {{ $comment->content }}) {
            button.hidden = false;
            } else {
            button.hidden = true;
            }
            "
                >{{ $comment->content }}
    </textarea><!-- campo di testo commento-->

    <div
        class="comment-text"
        id="comment_div_{{ $comment->id }}"
            >{{ $comment->content }}
        <!-- visualizzazione commento -->
    </div>
    @if(\Illuminate\Support\Facades\Auth::check()) <!-- se è loggato -->
        @if(\Illuminate\Support\Facades\Auth::id() != $comment->author_id) <!-- se non è autore del commento -->

                <button style="height: 40px; margin-left: auto"
                     onclick="
                         document.getElementById('response_{{$comment->id}}').hidden = !document.getElementById('response_{{$comment->id}}').hidden;
                         document.getElementById('content-area_{{$comment->id}}').focus();"
                >
                    Rispondi
                </button> <!-- bottone rispondi -->
            <form
                id="response_{{$comment->id}}"
                action="/comment/{{$event->id}}/{{$comment->id}}"
                method="POST"
                hidden
            >
                @csrf
                <textarea name="content"
                          onfocus="auto_grow(this)"
                          oninput="auto_grow(this)"
                          id="content-area_{{$comment->id}}"
                          style="width: 100%; resize: none"
                          placeholder="Rispondi al commento..."
                ></textarea>                                 <!-- area di testo risposta commento -->
                <input type="submit" value="Invia risposta"> <!--bottone invia risposta -->
            </form>
        @else <!-- se è autore del commento -->
                <div style="display: flex; flex-direction: row; margin-left: auto">
                    <!-- modifica button-->
                    <button style="height: 40px; margin-right: 10px;"
                         onclick="
                             let comment_area = document.getElementById('comment_area_{{ $comment->id }}');
                             let comment_div = document.getElementById('comment_div_{{ $comment->id }}');
                             comment_area.removeAttribute('disabled');
                             comment_area.hidden = false;
                             comment_div.hidden = true;
                             document.getElementById('update_form_{{$comment->id}}').hidden = false;
                             comment_area.focus();
                             "
                    >
                        Modifica
                    </button>                                                                <!-- bottone modifica-->
                    <form action="/comment/{{ $event->id }}/{{$comment->id}}" method="POST"> <!-- bottone elimina-->
                        @csrf
                        @method('DELETE')
                        <input style="height: 40px;" type="submit" value="Cancella" >

                    </form>

                </div>
                <form id="update_form_{{$comment->id}}" action="/comment/{{$event->id}}/{{$comment->id}}"
                      method="POST"
                      hidden
                      onfocusout="document.getElementById('response_{{$comment->id}}').hidden = true;"
                > <!-- applica modifiche commento -->
                    @csrf
                    @method('PUT')

                    <input type="submit" value="Applica modifiche">
                </form>
        @endif
    @endif
    </div>
    @foreach($comment->comments as $comment)
        <ul style="margin-top: 12px; list-style-type: none; list-style-position: outside;">
            @include('components.comment')
        </ul>
    @endforeach
</li>
