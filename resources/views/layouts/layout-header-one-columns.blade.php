<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>EventApp</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}">
</head>
<body>

<div class="whole-page-one-columns">
    @include('components.header')
    @include('components.notifications')

    @yield('content')
</div>


</body>
</html>
