<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>EventApp</title>
    @yield('style')
</head>
<body>

<div class="whole-page-two-columns">
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
            <button class="header-button" type="submit" value="In evidenza" >In evidenza</button>
        </form>
        <form action="/events">
            <button class="header-button" type="submit" value="Esplora" >Esplora</button>
        </form>
        <form action="#">
            <button class="header-button" type="submit" value="Forum" >Forum</button>
        </form>


        <div style="width: 100%"></div> <!--spacer-->
        @if (Route::has('login'))
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="header-button" style="margin-left: auto; margin-right: 12px;" type="submit" value="Logout" >Logout</button>
                </form>
            @else
                <form action="{{ route('login') }}">
                    <button class="header-button" style="margin-left: auto; margin-right: 4px;" type="submit" value="Login" >Login</button>
                </form>
                @if (Route::has('register'))
                    <form action="{{ route('register') }}">
                        <button class="header-button" style="margin-right: 12px;" type="submit" value="Registrati" >Registrati</button>
                    </form>
                @endif
            @endauth
        @endif
    </div>
    @yield('content')
</div>


</body>
</html>
