<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create event</title>
</head>
<body>
<h1>Creazione evento</h1>
<form style="display: flex; flex-direction: column" action="/events" method="post">
    @csrf
    <label for="title">Titolo</label>
    <input name="title" type="text" placeholder="..." required>
    <label for="description">Descrizione</label>
    <input type="text" name="description" placeholder="..." required>
    <label for="type">Tipo evento</label>
    <input type="text" name="type" required>
    <label for="max_partecipants">Numero partecipanti</label>
    <input type="number" name="max_partecipants" value="0" placeholder="">
    <label for="price">Prezzo</label>
    <input type="number" name="price" value="0" placeholder="">
    <label for="ticket_office">Biglietteria</label>
    <input type="url" name="ticket_office" value="">
    <label for="website">Sito web</label>
    <input type="url" name="website" value="">
    <label for="address">Indirizzo</label>
    <input type="text" name="address" required>
    <label for="starting_time">Data inizio evento</label>
    <input type="datetime-local" name="starting_time" required>
    <label for="ending_time">Data fine evento</label>
    <input type="datetime-local" name="ending_time" value="1900-01-01 00:00">

    <input type="submit" value="Crea evento!">
</form>
</body>
</html>
