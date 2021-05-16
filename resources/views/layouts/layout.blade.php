<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EventApp</title>
    @yield('style')
</head>
<body>

<header>
    <nav>
        <div class="header" >
            <h1>Header</h1>
            <p>My supercool header</p>
        </div>
    </nav>
</header>
<!--<header>
    <nav>
        <div data-role="header" data-position="inline" style="color: #00ff00; width: 100%">
            <div>
                <h1 style="display: block; float:left;">EventApp</h1>
            </div>
            <div class="btn-group">
                <input style="display: block; float:left;" type="button" value="home">
                <input style="display: block; float:left;" type="button" value="In evidenza">
                <input style="display: block; float:left;" type="button" value="Esplora">
                <input style="display: block; float:left;" type="button" value="Form">
            </div>
            <input style="display: block; float:left;" type="button" value="Login">
        </div>
    </nav>
</header>-->


@yield('content')

</body>
</html>
