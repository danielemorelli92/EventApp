<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EventApp</title>
    @yield('style')
</head>
<body>

<div class="whole-page-two-columns">
    <div class="header" style="width: 100%">

        <div class="header-logo" style="margin: 12px;">EventsApp</div>
        <input class="header-tabs" type="button" value="home">
        <input class="header-tabs" type="button" value="In evidenza">
        <input class="header-tabs" type="button" value="Esplora">
        <input class="header-tabs" type="button" value="Form">
        <input style="margin-left: auto; margin-right: 4px;" type="button" value="Registrati">
        <input style="margin-right: 12px;" type="button" value="Login">
    </div>
    @yield('content')
</div>


</body>
</html>
