@extends('layouts.layout-header-one-columns')


@section('content')
    <div class="main-content-column">
        <div class="big-form-container">
            <form style="display: flex; flex-direction: column;" method="post" action="/events">
                @csrf
                <h2 style="margin-bottom: 20px;">Informazioni dell'evento</h2>
                <div class="big-form-group">
                    <div class="big-form-column"><label class="big-form-label" for="title">Titolo</label>
                        <input class="big-form-big-field" name="title" type="text" placeholder="..." required></div>
                    <div class="big-form-column"><label class="big-form-label" for="description">Descrizione</label><textarea class="big-form-big-field" type="text" name="description" placeholder="..." required></textarea></div>
                    <div class="big-form-column"><label class="big-form-label" for="city">Città</label><input class="big-form-big-field" type="text" name="city" required></div>
                    <div class="big-form-row"><label class="big-form-label" for="type">Tipo evento</label><input class="big-form-compact-field" type="text" name="type" required></div>
                    <div class="big-form-row"><label class="big-form-label" for="max_partecipants">Numero partecipanti</label><input class="big-form-compact-field" type="number" min="0" name="max_partecipants" placeholder=""></div>
                    <div class="big-form-row"><label class="big-form-label" for="price">Prezzo</label><input class="big-form-compact-field" type="number" min="0" step="0.01" name="price" placeholder=""></div>
                    <div class="big-form-row"><label class="big-form-label" for="ticket_office">Biglietteria</label><input class="big-form-compact-field" type="text" id="ticket_office" name="ticket_office"></div>
                    <div class="big-form-row"><label class="big-form-label" for="website">Sito web</label><input class="big-form-compact-field" type="text" id="website" name="website"></div>
                    <div class="big-form-row"><label class="big-form-label" for="starting_time">Data inizio evento</label><input class="big-form-compact-field" type="datetime-local" onchange="
                                                                                                                                 if (document.getElementById('ending_time').value < this.value) {
                                                                                                                                     document.getElementById('ending_time').value = this.value;
                                                                                                                                 }
                                                                                                                                 document.getElementById('ending_time').min = this.value;"
                                                                                                                                 min="{{str_replace(" ", "T",substr(date(now()), 0, 16))}}" id="starting_time" name="starting_time" required ></div>
                    <div class="big-form-row"><label class="big-form-label" for="ending_time">Data fine evento</label><input class="big-form-compact-field" type="datetime-local" id="ending_time" name="ending_time"></div>
                    <div class="big-form-row" style="width: auto">
                        <label class="big-form-label" style="min-width: 400px" for="registration_link">Richiedi registrazione da sito esterno</label>
                        <div class="radio-selection-item" style="flex-grow: 1">
                            <input onclick="document.getElementById('ticket_office').required = false; document.getElementById('website').required = false" type="radio" class="radio-selection-item-radio" name="registration_link" value="none" checked>
                            <label for="registration_link" class="radio-selection-item-label" >No</label>
                        </div>
                        <div class="radio-selection-item" style="flex-grow: 1">
                            <input onclick="document.getElementById('ticket_office').required = true; document.getElementById('website').required = false" type="radio" class="radio-selection-item-radio" name="registration_link" value="ticket_office">
                            <label for="registration_link" class="radio-selection-item-label" >Dalla biglietteria</label>
                        </div>
                        <div class="radio-selection-item" style="flex-grow: 1">
                            <input onclick="document.getElementById('website').required = true; document.getElementById('ticket_office').required = false" type="radio" class="radio-selection-item-radio" name="registration_link" value="website">
                            <label for="registration_link" class="radio-selection-item-label" >Dal sito web</label>
                        </div>
                    </div>


                    <label for="criteri_accettazione">Criteri accettazione:</label>
                        <textarea id="" name="criteri_accettazione">
                        </textarea>

                    <button class="big-form-submit-button" type="submit" value="Crea evento">Crea evento</button>
                </div>
            </form>

        </div>
    </div>


@endsection

