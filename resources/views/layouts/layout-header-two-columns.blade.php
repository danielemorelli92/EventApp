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
        <div class="header-logo" style="margin: 12px;">EventsApp</div>


        @if (Route::has('login'))
            @auth
                <form action="{{ route('dashboard') }}">
                    <input class="header-tabs" type="submit" value="Area personale" />
                </form>
            @else
            @endauth
        @endif
        <form action="/welcome">
            <input class="header-tabs" type="submit" value="In evidenza"/>
        </form>
        <form action="/events">
            <input class="header-tabs" type="submit" value="Esplora"/>
        </form>
        <form action="#">
            <input class="header-tabs" type="submit" value="Forum"/>
        </form>


        <div style="width: 100%"></div> <!--spacer-->
        @if (Route::has('login'))
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input style="margin-left: auto; margin-right: 12px;" type="submit" value="Logout" />
                </form>
            @else
                <form action="{{ route('login') }}">
                    <input style="margin-left: auto; margin-right: 4px;" type="submit" value="Login" />
                </form>
                @if (Route::has('register'))
                    <form action="{{ route('register') }}">
                        <input style="margin-right: 12px;" type="submit" value="Registrati" />
                    </form>
                @endif
            @endauth
        @endif
    </div>
    @yield('content')
</div>


</body>
</html>
