<!doctype html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modifica account</title>
</head>
<body>
<h1>Modifica dati utente</h1>
<form action="/" style="display: flex; flex-direction: column;">
    <label for="name">Nome</label>
    <input id="name" name="name" type="text" value="{{ \Illuminate\Support\Facades\Auth::user()->name }}">
    <label for="email">Email</label>
    <input id="email" name="email" type="email" value="{{ \Illuminate\Support\Facades\Auth::user()->email }}">
    <label for="birthday">Data di nascita</label>
    <input type="date" id="birthday" name="birthday">
    <label for="numero_telefono">Numero di telefono</label>
    <input id="numero_telefono" name="numero_telefono" type="tel"
           value="{{ \Illuminate\Support\Facades\Auth::user()->numero_telefono }}">
    <label for="sito_web">Sitoweb</label>
    <input type="text" value="{{ \Illuminate\Support\Facades\Auth::user()->sito_web }}" id="sito_web" name="sito_web">
</form>
</body>
</html>
