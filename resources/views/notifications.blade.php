<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Notifiche utente</title>
</head>
<body style="display: flex; flex-direction: row; justify-content: center; font-size: 30px">
<div style="display: flex; flex-direction: column; justify-content: center;">
    <h1 style="align-self: center">Notifiche</h1>
    @foreach(\App\Models\User::find(\Illuminate\Support\Facades\Auth::id())->notifications as $notification)
        @switch($notification->type)
            @case(\App\Notifications\TitleChanged::class)
            <div style="border: 2px solid black; width: 700px;">
                @if($notification->read_at == null)
                    <strong>Il titolo di un <a href="/event/{{$notification->data['event_id']}}">evento</a> a cui sei
                        registrato è stato modificato!<br><br>
                        Data notifica: {{ $notification->created_at }}</strong>
                @else
                    Il titolo di un <a href="/event/{{$notification->data['event_id']}}">evento</a> a cui sei registrato
                    è stato modificato!<br><br>
                    Data notifica: {{ $notification->created_at }}
                @endif
            </div>
            @break
            @case(\App\Notifications\DescriptionChanged::class)
            <div style="border: 2px solid black; width: 700px;">
                @if($notification->read_at == null)
                    <strong>La descrizione di un <a href="/event/{{$notification->data['event_id']}}">evento</a> a cui
                        sei registrato è stata modificata!<br><br>
                        Data notifica: {{ $notification->created_at }}</strong>
                @else
                    La descrizione di un <a href="/event/{{$notification->data['event_id']}}">evento</a> a cui sei
                    registrato è stata modificata!<br><br>
                    Data notifica: {{ $notification->created_at }}
                @endif
            </div>
            @break
            @case(\App\Notifications\AddressChanged::class)
            <div style="border: 2px solid black; width: 700px;">
                @if($notification->read_at == null)
                    <strong>La posizione di un <a href="/event/{{$notification->data['event_id']}}">evento</a> a cui sei
                        registrato è stata modificata!<br><br>
                        Data notifica: {{ $notification->created_at }}</strong>
                @else
                    La posizione di un <a href="/event/{{$notification->data['event_id']}}">evento</a> a cui sei
                    registrato è stata modificata!<br><br>
                    Data notifica: {{ $notification->created_at }}
                @endif
            </div>
            @break
            @case(\App\Notifications\DateChanged::class)
            <div style="border: 2px solid black; width: 700px;">
                @if($notification->read_at == null)
                    <strong>La data di un <a href="/event/{{$notification->data['event_id']}}">evento</a> a cui sei
                        registrato è stata modificata!<br><br>
                        Data notifica: {{ $notification->created_at }}</strong>
                @else
                    La data di un <a href="/event/{{$notification->data['event_id']}}">evento</a> a cui sei registrato è
                    stata modificata!<br><br>
                    Data notifica: {{ $notification->created_at }}
                @endif
            </div>
            @break
            @case(\App\Notifications\EventCanceled::class)
            <div style="border: 2px solid black; width: 700px;">
                @if($notification->read_at == null)
                    <strong>Un <a href="/event/{{$notification->data['event_id']}}">evento</a> a cui eri registrato è
                        stato cancellato!<br><br>
                        Data notifica: {{ $notification->created_at }}</strong>
                @else
                    Un <a href="/event/{{$notification->data['event_id']}}">evento</a> a cui eri registrato è stato
                    cancellato!<br><br>
                    Data notifica: {{ $notification->created_at }}
                @endif
            </div>
            @break
        @endswitch
        @php
            $notification->markAsRead()
        @endphp
    @endforeach
</div>
</body>
</html>
