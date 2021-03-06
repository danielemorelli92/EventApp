
<script>
    function toggleNotificationsPopup() {
        notifications_popup = document.getElementById("notifications-popup");
        notifications_icon = document.getElementById("notifications-icon");

        notifications_popup.className = (notifications_popup.className === 'show' ? 'hide' : 'show');

        if (notifications_popup.className === 'show') { // è stata aperto
            notifications_icon.src = "/images/notification-icon-fill.svg";
            setTimeout(function () {
                notifications_popup.style.display = 'block';
            }, 0); // timed to occur immediately

        } else { // è stato chiuso
            notifications_icon.src = "/images/notification-icon-outline.svg";
            setTimeout(function () {
                notifications_popup.style.display = 'none';
            }, 200); // timed to match animation-duration
        }

    }
</script>


@if (\Illuminate\Support\Facades\Route::has('login'))
    @auth
        @if(\App\Models\User::find(\Illuminate\Support\Facades\Auth::id())->notifications->isNotEmpty())
            <div id="notifications-popup">
                <div class="notifications-container">
                    @foreach(\App\Models\User::find(\Illuminate\Support\Facades\Auth::id())->notifications as $notification)
                        @switch($notification->type)
                            @case(\App\Notifications\TitleChanged::class)
                            <a class="notification-item" href="/event/{{$notification->data['event_id']}}">
                                <div
                                    @if($notification->read_at == null)
                                    class="notification-item-title-unread"
                                    @else
                                    class="notification-item-title"
                                    @endif
                                >
                                    Il titolo di un evento a cui sei registrato è
                                    stato modificato!@break
                                    @case(\App\Notifications\DescriptionChanged::class)
                                    <a class="notification-item" href="/event/{{$notification->data['event_id']}}">
                                        <div
                                            @if($notification->read_at == null)
                                            class="notification-item-title-unread"
                                            @else
                                            class="notification-item-title"
                                            @endif
                                        >
                                            La descrizione di un evento a cui sei
                                            registrato è stata modificata!@break
                                            @case(\App\Notifications\CityChanged::class)
                                            <a class="notification-item" href="/event/{{$notification->data['event_id']}}">
                                                <div
                                                    @if($notification->read_at == null)
                                                    class="notification-item-title-unread"
                                                    @else
                                                    class="notification-item-title"
                                                    @endif
                                                >La posizione di un evento a cui sei
                                                    registrato è stata modificata!@break
                                                    @case(\App\Notifications\DateChanged::class)
                                                    <a class="notification-item" href="/event/{{$notification->data['event_id']}}">
                                                        <div
                                                            @if($notification->read_at == null)
                                                            class="notification-item-title-unread"
                                                            @else
                                                            class="notification-item-title"
                                                            @endif
                                                        >La data di un evento a cui sei registrato è
                                                            stata modificata!@break
                                                            @case(\App\Notifications\EventCanceled::class)
                                                            <a class="notification-item" >
                                                                <div
                                                                    @if($notification->read_at == null)
                                                                    class="notification-item-title-unread"
                                                                    @else
                                                                    class="notification-item-title"
                                                                    @endif
                                                                >Un evento a cui eri registrato è stato
                                                                    cancellato!
                                                                    @break
                                                                    @case(\App\Notifications\ReplyToMe::class)
                                                                    <a class="notification-item" href="/event/{{$notification->data['event_id']}}">
                                                                        <div
                                                                            @if($notification->read_at == null)
                                                                            class="notification-item-title-unread"
                                                                            @else
                                                                            class="notification-item-title"
                                                                            @endif
                                                                        >Qualcuno ha risposto ad un tuo commento! @break
                                                                            @case(\App\Notifications\MessageToMe::class)
                                                                            <a class="notification-item" href="/chats">
                                                                                <div
                                                                                    @if($notification->read_at == null)
                                                                                    class="notification-item-title-unread"
                                                                                    @else
                                                                                    class="notification-item-title"
                                                                                    @endif
                                                                                >Qualcuno ti ha mandato un messaggio! @break
                                                                                    @endswitch
                                                                                </div>
                                                                                <div class="notification-item-date">
                                                                                    Data notifica: {{ $notification->created_at }}</div>
                                                                            </a>
                                                                            @php
                                                                                $notification->markAsRead()
                                                                            @endphp
                                                                            @endforeach
                                                                        </div>
                                                                </div>
        @endif

    @endauth
@endif
