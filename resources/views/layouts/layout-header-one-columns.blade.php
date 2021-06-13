<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>EventApp</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}">
</head>
<body>


<script>
    function toggleNotificationsPopup() {
        notifications_popup = document.getElementById("notifications-popup");

        notifications_popup.className = notifications_popup.className !== 'show' ? 'show' : 'hide';
        if (notifications_popup.className === 'show') {
            setTimeout(function () {
                notifications_popup.style.display = 'block';
            }, 0); // timed to occur immediately
        } else {
            setTimeout(function () {
                notifications_popup.style.display = 'none';
            }, 200); // timed to match animation-duration
        }

    }
</script>


<div id="notifications-popup">
    <div class="notifications-container">
        @foreach(\App\Models\User::find(\Illuminate\Support\Facades\Auth::id())->notifications as $notification)
            @switch($notification->type)
                @case(\App\Notifications\TitleChanged::class)
                <a class="notification-item" href="/event/{{$notification->data['event_id']}}">
                    @if($notification->read_at == null)
                        <label class="notification-item-title-unread">Il titolo di un evento a cui sei
                            registrato è stato modificato!
                        </label>
                        <label class="notification-item-date">
                            Data notifica: {{ $notification->created_at }}</label>
                    @else
                        <label class="notification-item-title">
                        Il titolo di un evento a cui sei registrato
                        è stato modificato!
                        </label>
                        <label class="notification-item-date">
                            Data notifica: {{ $notification->created_at }}</label>
                    @endif
                </a>
                @break
                @case(\App\Notifications\DescriptionChanged::class)
                <a class="notification-item" href="/event/{{$notification->data['event_id']}}">
                    @if($notification->read_at == null)
                        <label class="notification-item-title-unread">La descrizione di un evento a cui
                            sei registrato è stata modificata!</label>>
                        <label class="notification-item-date">
                            Data notifica: {{ $notification->created_at }}</label>
                    @else
                        <label class="notification-item-title">
                        La descrizione di un evento a cui sei
                        registrato è stata modificata!
                        </label>
                        <label class="notification-item-date">
                            Data notifica: {{ $notification->created_at }}</label>
                    @endif
                </a>
                @break
                @case(\App\Notifications\AddressChanged::class)
                <a class="notification-item" href="/event/{{$notification->data['event_id']}}">
                    @if($notification->read_at == null)
                        <label class="notification-item-title-unread">La posizione di un evento a cui sei
                            registrato è stata modificata!</label>
                        <label class="notification-item-date">
                            Data notifica: {{ $notification->created_at }}</label>
                    @else
                        <label class="notification-item-title">
                            La posizione di un evento a cui sei
                            registrato è stata modificata!
                        </label>
                        <label class="notification-item-date">
                            Data notifica: {{ $notification->created_at }}</label>
                    @endif
                </a>
                @break
                @case(\App\Notifications\DateChanged::class)
                <a class="notification-item" href="/event/{{$notification->data['event_id']}}">
                    @if($notification->read_at == null)
                        <label class="notification-item-title-unread">La data di un evento a cui sei
                            registrato è stata modificata!
                        </label>
                        <label class="notification-item-date">
                            Data notifica: {{ $notification->created_at }}</label>
                    @else
                        <label class="notification-item-title">
                            La data di un evento a cui sei registrato è
                            stata modificata!
                        </label>
                        <label class="notification-item-date">
                            Data notifica: {{ $notification->created_at }}</label>
                    @endif
                </a>
                @break
                @case(\App\Notifications\EventCanceled::class)
                <a class="notification-item" href="/event/{{$notification->data['event_id']}}">
                    @if($notification->read_at == null)
                        <label class="notification-item-title-unread">Un evento a cui eri registrato è
                            stato cancellato!
                        </label>
                        <label class="notification-item-date">
                            Data notifica: {{ $notification->created_at }}
                        </label>
                    @else
                        <label class="notification-item-title">
                            Un evento a cui eri registrato è stato
                            cancellato!
                        </label>
                        <label class="notification-item-date">
                            Data notifica: {{ $notification->created_at }}</label>
                    @endif
                </a>
                @break
            @endswitch
            @php
                $notification->markAsRead()
            @endphp
        @endforeach
    </div>
</div>
<div class="whole-page-one-columns">
    <div class="header" style="width: 100%">
        <div class="header-logo-container">
            <img src="{{ url('/images/logo-header.svg') }}" style="width: 171px; height: 40px;" alt="logo-header">
        </div>


        @if (Route::has('login'))
            @auth
                @if (!Gate::allows('create-request') || count(Auth::user()->createdEvents) > 0)
                    @auth
                        <form action="/events/manage">
                            <button class="header-button" type="submit" value="Gestione eventi">Gestione eventi</button>
                        </form>
                    @endauth
                @endif
                <form action="{{ route('dashboard') }}">
                    <button class="header-button" type="submit" value="Area personale">Area personale</button>
                </form>
            @else
            @endauth
        @endif
        <form action="/events-highlighted">
            <button class="header-button" type="submit" value="In evidenza">In evidenza</button>
        </form>
        <form action="/events">
            <button class="header-button" type="submit" value="Esplora">Esplora</button>
        </form>
        <form action="#">
            <button class="header-button" type="submit" value="Forum">Forum</button>
        </form>


        <div style="width: 100%"></div> <!--spacer-->
        @if (Route::has('login'))
            @auth
                <button class="header-button" onclick="toggleNotificationsPopup()"
                        style="margin-left: auto; margin-right: 12px;"
                        value="Notifiche">Notifiche
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="header-button" style="margin-left: auto; margin-right: 12px;" type="submit"
                            value="Logout">Logout
                    </button>
                </form>
            @else
                <form action="{{ route('login') }}">
                    <button class="header-button" style="margin-left: auto; margin-right: 4px;" type="submit"
                            value="Login">Login
                    </button>
                </form>
                @if (Route::has('register'))
                    <form action="{{ route('register') }}">
                        <button class="header-button" style="margin-right: 12px;" type="submit" value="Registrati">
                            Registrati
                        </button>
                    </form>
                @endif
            @endauth
        @endif
    </div>
    @yield('content')
</div>


</body>
</html>
