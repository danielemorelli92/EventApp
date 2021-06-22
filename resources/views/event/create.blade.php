@extends('layouts.layout-header-one-columns')


@section('content')
    <div class="main-content-column">
        <div class="big-form-container">
            <form style="display: flex; flex-direction: column;" method="post" action="/events"
                  enctype="multipart/form-data">
                @csrf
                <h2 style="margin-bottom: 20px;">Informazioni dell'evento</h2>
                <div class="big-form-group">
                    <div class="big-form-column">
                        <label class="big-form-label" for="title">Titolo*</label>
                        <input class="big-form-big-field" name="title" type="text" placeholder="..." required>
                    </div>
                    <div class="big-form-column">
                        <label class="big-form-label" for="description">Descrizione*</label>
                        <textarea style="resize: vertical;" class="big-form-big-field" type="text" name="description" placeholder="..." required ></textarea>
                    </div>
                    <div class="big-form-column">
                        <label class="big-form-label" for="city">Città*</label>
                        <input class="big-form-big-field" type="text" name="city" required>
                    </div>
                    <div class="big-form-row" style="display: none">
                        <label style="display: none" class="big-form-label" for="type">Tipo evento*</label>
                        <input style="display: none" class="big-form-compact-field" type="text" name="type" value="type">
                    </div>
                    <div class="big-form-row">
                        <label class="big-form-label" for="max_partecipants">Numero posti</label>
                        <input class="big-form-compact-field" type="number" min="0" name="max_partecipants" placeholder="">
                    </div>
                    <div class="big-form-row">
                        <label class="big-form-label" for="price">Prezzo</label>
                        <input class="big-form-compact-field" type="number" min="0" step="0.01" name="price" placeholder="">
                    </div>
                    <div class="big-form-row">
                        <label class="big-form-label" for="ticket_office">Biglietteria</label>
                        <input class="big-form-compact-field" type="text" id="ticket_office" name="ticket_office">
                    </div>
                    <div class="big-form-row">
                        <label class="big-form-label" for="website">Sito web</label>
                        <input class="big-form-compact-field" type="text" id="website" name="website">
                    </div>
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
                    <div class="big-form-row">
                        <label class="big-form-label" for="starting_time">Data inizio evento*</label>
                        <input class="big-form-compact-field" type="datetime-local" onchange="

                         if (document.getElementById('ending_time').value !=='' && document.getElementById('ending_time').value != null && document.getElementById('ending_time').value < this.value) {
                              document.getElementById('ending_time').value = this.value;
                          }
                          document.getElementById('ending_time').min = this.value;
                         if (document.getElementById('offer_start').value !=='' && document.getElementById('offer_start').value != null && document.getElementById('offer_start').value > this.value) {
                              document.getElementById('offer_start').value = this.value;
                         }
                          document.getElementById('offer_start').max = this.value;"
                          min="{{str_replace(" ", "T",substr(date(now()), 0, 16))}}" id="starting_time" name="starting_time" required >
                    </div>
                    <div class="big-form-row">
                        <label class="big-form-label" for="ending_time">Data fine evento</label>
                        <input class="big-form-compact-field" type="datetime-local" id="ending_time" name="ending_time">
                    </div>


                    <div class="big-form-row">
                        <label class="big-form-label" for="offer_discount">Sconto del %</label>
                        <input class="big-form-compact-field" type="number" id="offer_discount" name="offer_discount" placeholder="%" min="1" max="100"
                               onchange="
                            if (this.value !== '') {
                                this.setAttribute('required', 'required');
                                document.getElementById('offer_start').setAttribute('required', 'required');
                            } else if (document.getElementById('offer_start').value === '') {
                                this.removeAttribute('required');
                                document.getElementById('offer_start').removeAttribute('required');
                            }
                         ">
                    </div>
                    <div class="big-form-row">
                        <label class="big-form-label" for="offer_start">Data inizio offerta</label>
                        <input class="big-form-compact-field" type="datetime-local" onchange="
                         if (document.getElementById('offer_end').value !=='' && document.getElementById('offer_end').value != null && document.getElementById('offer_end').value < this.value) {
                              document.getElementById('offer_end').value = this.value;
                         } document.getElementById('offer_end').min = this.value;
                         if (this.value !== '') {
                             this.setAttribute('required', 'required');
                             document.getElementById('offer_discount').setAttribute('required', 'required');
                         } else if (document.getElementById('offer_discount').value === '') {
                             this.removeAttribute('required');
                             document.getElementById('offer_discount').removeAttribute('required');
                         }
                         "
                         id="offer_start" name="offer_start" >
                    </div>
                    <div class="big-form-row">
                        <label class="big-form-label" for="offer_end">Data fine offerta</label>
                        <input class="big-form-compact-field" type="datetime-local" id="offer_end" name="offer_end">
                    </div>


                        <div class="big-form-column" style="margin-top: 8px">
                            <label class="big-form-label" style="min-width: 400px" for="upload-label">Carica
                                immagini</label>
                            <div id="images_flex"
                                 style="width: 100%; display: flex; flex-direction: row; flex-wrap: wrap">
                                <label style="margin-left: auto; margin-top: auto; margin-right: 4px" id="upload-label"
                                       class="custom-file-upload">
                                    <input type="file" name="images[]" multiple="multiple" accept="image/*"
                                           onchange="
                                                var images_flex = document.getElementById('images_flex');
                                                upload_button = document.getElementById('upload-label');
                                                images_flex.innerHTML = '';
                                                for (let i = 0; i < files.length; i++) {
                                                     image_view_temp = document.createElement('img');
                                                     image_view_temp.className = 'uploaded-image-preview';
                                                     image_view_temp.src = window.URL.createObjectURL(files[i]);

                                                     images_flex.append(image_view_temp);
                                                }
                                                images_flex.append(upload_button);
                                           ">
                                    Scegli immagini da caricare
                                </label>
                            </div>
                        </div>
                    <div class="big-form-column" style="margin-top: 8px">
                        <label class="big-form-label" style="min-width: 400px" for="upload-label">Seleziona categorie</label>
                        <div style="display: flex; flex-direction: row; flex-wrap: wrap; margin-bottom: 8px" >
                            @foreach(collect(\App\Models\Tag::orderBy('body')->get()) as $tag)
                                <div style="display: flex; flex-direction: row; border: 2px solid #000000" class="category-oval" id="oval_{{ $tag->id }}"
                                    onclick="
                                        oval = document.getElementById('oval_{{ $tag->id }}');
                                        checkbox = document.getElementById('checkbox_{{ $tag->id }}');
                                        if (!checkbox.hasAttribute('checked')) {
                                            checkbox.setAttribute('checked', 'checked');
                                            oval.style.color = '#0090E1'
                                            oval.style.border = '2px solid #0090E1';
                                        } else {
                                            checkbox.removeAttribute('checked');
                                            oval.style.color = '#000000'
                                            oval.style.border = '2px solid #000000';
                                        }
                                        "
                                >
                                    <input type="checkbox" hidden class="checkbox-selection-item-checkbox" name="categories[]"
                                           id="checkbox_{{ $tag->id }}"
                                           value="{{ $tag->id }}"
                                           onchange="document.getElementById('preferences').submit()">
                                    <label style="margin-right: 3px; -moz-user-select: none;-khtml-user-select: none;-webkit-user-select: none;-ms-user-select: none;
                                                    user-select: none;"
                                           class="checkbox-selection-item-label" for="categories[]">{{ $tag->body }}</label>
                                </div>
                            @endforeach
                        </div>



                        <div class="big-form-column">
                            <label class="big-form-label" for="criteri_accettazione" style="min-width: 400px">Criteri di
                                accettazione</label>
                            <textarea class="big-form-big-field" id="" name="criteri_accettazione"
                                      style="resize: vertical;"></textarea>
                        </div>
                        <button class="big-form-submit-button" type="submit" value="Crea evento">Crea evento</button>
                    </div>

                </div>
            </form>

        </div>
    </div>


@endsection

