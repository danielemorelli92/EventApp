<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit event</title>
</head>
<body>
<h1>Modifica evento</h1>
<form style="display: flex; flex-direction: column" action="/events" method="post">
    @csrf
    @method('PUT')
    <label for="title">Titolo</label>
    <input name="title" type="text" placeholder="..." value="{{ $event->title }}" required>
    <label for="description">Descrizione</label>
    <input type="text" name="description" placeholder="..." value="{{ $event->description }}" required>
    <label for="type">Tipo evento</label>
    <input type="text" name="type" value="{{ $event->type }}" required>
    <label for="max_partecipants">Numero partecipanti</label>
    <input type="number" name="max_partecipants" placeholder="" value="{{ $event->max_partecipants }}">
    <label for="price">Prezzo</label>
    <input type="number" name="price" placeholder="" value="{{ $event->price }}">
    <label for="ticket_office">Biglietteria</label>
    <input type="text" name="ticket_office" value="{{ $event->ticket_office }}">
    <label for="website">Sito web</label>
    <input type="text" name="website" value="{{ $event->website }}">
    <label for="address">Indirizzo</label>
    <input type="text" name="address" value="{{ $event->address }}" required>
    <label for="starting_time">Data inizio evento</label>
    <input type="datetime-local" name="starting_time" value="{{ $event->starting_time }}" required>
    <label for="ending_time">Data fine evento</label>
    <input type="datetime-local" name="ending_time" value="{{ $event->ending_time }}">

    <input type="submit" value="Modifica evento!">
</form>
</body>
</html>
