<div class="header" style="width: 100%">

        <a class="header-logo-container" href="/">
            <img src="{{ url('/images/logo-header.svg') }}" style="-webkit-filter: drop-shadow(1px 1px 4px rgba(0, 0, 0, 0.25)); filter: drop-shadow(1px 1px 4px rgba(0, 0, 0, 0.25)); width: 171px; height: 40px;" alt="logo-header">
        </a>


    @if (\Illuminate\Support\Facades\Route::has('login'))
        @auth
            @if (\Illuminate\Support\Facades\Gate::allows('admin'))
                @auth
                    <form action="/admin_page">
                        <button class="header-button" type="submit" value="Amministrazione">Amministrazione</button>
                    </form>
                @endauth
            @endif
            @if (!\Illuminate\Support\Facades\Gate::allows('create-request') || count(\Illuminate\Support\Facades\Auth::user()->createdEvents) > 0)
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


    <div style="width: 100%"></div> <!--spacer-->
        @if (\Illuminate\Support\Facades\Route::has('login'))
            @auth
            @if(\App\Models\User::find(\Illuminate\Support\Facades\Auth::id())->notifications->isNotEmpty())
                <div class="header-icon-button-container" onclick="toggleNotificationsPopup()" style="margin-left: auto; margin-right: 12px;">
                    @if(\App\Models\User::find(\Illuminate\Support\Facades\Auth::id())->notifications->get(0)->read_at == null )
                        <img id="notifications-icon"  class="header-icon-preview" src="{{ url('/images/notification-icon-outline-unread.svg') }}" alt="">
                    @else
                        <img id="notifications-icon"  class="header-icon-preview" src="{{ url('/images/notification-icon-outline.svg') }}" alt="">
                    @endif
                </div>
            @endif
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
            @if (\Illuminate\Support\Facades\Route::has('register'))
                <form action="{{ route('register') }}">
                    <button class="header-button" style="margin-right: 12px;" type="submit" value="Registrati">
                        Registrati
                    </button>
                </form>
            @endif
        @endauth
    @endif
</div>
