@extends('layouts.layout-header-one-columns')


@section('content')

    <div class="main-content-column">
        <div class="big-form-container">

            <h2 style="margin-bottom: 20px;">Termini di contratto</h2>

            <div class="big-form-group">

                <div style="margin-top: 1px; background: white; padding: 4px; border-radius: 6px; border: 1px solid #aaa; font-size: 18px">{{ $event->criteri_accettazione }}</div>


                <div style="margin-top: 16px; display: flex; flex-direction: row;" class="big-form-submit-button">

                    <form action="/event/{{$event->id}}">
                        <button style="margin-right: 4px;" type="submit">Annulla</button>
                    </form>
                    <form action="/registration" method="post">
                        @csrf
                        <button type="submit" name="event" value="{{ $event->id }}"
                        >Accetta e registrati
                        </button>
                    </form>
                </div>
            </div>


        </div>
    </div>


@endsection
