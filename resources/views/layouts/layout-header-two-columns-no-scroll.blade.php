<!DOCTYPE html>
<html lang="it">
<link>
    <meta charset="UTF-8">
    <title>EventApp</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}">
</head>
<body>

<div class="whole-page-two-columns" style="
    width: 100%;
    height: 100%;
    grid-template-rows: 64px calc(100% - 64px);
">
    @include('components.header')
    @include('components.notifications')

    @yield('content')
</div>


</body>
</html>
