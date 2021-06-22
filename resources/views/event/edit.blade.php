@extends('layouts.layout-header-one-columns')


@section('content')
    <div class="main-content-column">
        <div class="big-form-container">
            <form style="display: flex; flex-direction: column" action="/events/{{ $event->id }}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <h2 style="margin-bottom: 20px;">Informazioni dell'evento</h2>
                <div class="big-form-group">
                    <div class="big-form-column"><label class="big-form-label" for="title">Titolo*</label><input class="big-form-big-field" name="title" type="text" placeholder="titolo" value="{{ $event->title }}" required></div>
                    <div class="big-form-column"><label class="big-form-label" for="description">Descrizione*</label><textarea class="big-form-big-field" style="resize: vertical;" type="text" name="description" placeholder="descrizione" required>{{ $event->description }}</textarea></div>
                    <div class="big-form-column"><label class="big-form-label" for="city">Città*</label><input class="big-form-big-field" type="text" name="city" value="{{ $event->city }}" placeholder="città"  required></div>
                    <div class="big-form-row" style="display: none"><label style="display: none" class="big-form-label" for="type">Tipo evento*</label><input style="display: none" class="big-form-compact-field" type="text" name="type" value="type" ></div>
                    <div class="big-form-row"><label class="big-form-label" for="max_partecipants">Numero posti</label><input class="big-form-compact-field" type="number" min="0" name="max_partecipants" value="{{ $event->max_partecipants }}" placeholder="n. posti"></div>
                    <div class="big-form-row"><label class="big-form-label" for="price">Prezzo €</label><input class="big-form-compact-field" type="number" min="0.01" step="0.01" id="price" name="price" value="{{ $event->price }}" placeholder="prezzo €"></div>
                    <div class="big-form-row"><label class="big-form-label" for="ticket_office">Biglietteria</label><input class="big-form-compact-field" type="text" id="ticket_office" name="ticket_office" placeholder="https://sito.biglietteria.it/" value="{{ $event->ticket_office }}"
                            @if ($event->registration_link == 'ticket_office')
                                required
                            @endif
                        >
                    </div>
                    <div class="big-form-row"><label class="big-form-label" for="website">Sito web</label><input class="big-form-compact-field" type="text" id="website" name="website" placeholder="https://sito.web.it/" value="{{ $event->website }}"
                            @if ($event->registration_link == 'website')
                                required
                            @endif
                        ></div>
                    <div class="big-form-row" style="width: auto">
                        <label class="big-form-label" style="min-width: 400px" for="registration_link">Richiedi registrazione esterna</label>
                        <div class="radio-selection-item" style="flex-grow: 1">
                            <input onclick="document.getElementById('ticket_office').required = false; document.getElementById('website').required = false" type="radio" class="radio-selection-item-radio" name="registration_link" value="none"
                                   @if ($event->registration_link == 'none')
                                   checked
                                @endif
                            >
                            <label for="registration_link" class="radio-selection-item-label" >No</label>
                        </div>
                        <div class="radio-selection-item" style="flex-grow: 1">
                            <input onclick="document.getElementById('ticket_office').required = true; document.getElementById('website').required = false" type="radio" class="radio-selection-item-radio" name="registration_link" value="ticket_office"
                                   @if ($event->registration_link == 'ticket_office')
                                   checked
                                @endif
                            >
                            <label for="registration_link" class="radio-selection-item-label" >Dalla biglietteria</label>
                        </div>
                        <div class="radio-selection-item" style="flex-grow: 1">
                            <input onclick="document.getElementById('website').required = true; document.getElementById('ticket_office').required = false" type="radio" class="radio-selection-item-radio" name="registration_link" value="website"
                                   @if ($event->registration_link == 'website')
                                   checked
                                @endif
                            >
                            <label for="registration_link" class="radio-selection-item-label" >Dal sito web</label>
                        </div>
                    </div>
                    <div class="big-form-row"><label class="big-form-label" for="starting_time">Data inizio evento*</label>
                        <input class="big-form-compact-field" type="datetime-local"
                            onchange="
                            if (document.getElementById('ending_time').value < this.value && document.getElementById('ending_time').value != null && document.getElementById('ending_time').value !=='') {
                                document.getElementById('ending_time').value = this.value;
                            }
                            document.getElementById('ending_time').min = this.value;" id="starting_time" name="starting_time" value="{{ date('Y-m-d\TH:i:s', strtotime($event->starting_time)) }}" required></div>
                    <div class="big-form-row"><label class="big-form-label" for="ending_time">Data fine evento</label><input class="big-form-compact-field" type="datetime-local" id="ending_time" name="ending_time" onfocus="this.min = document.getElementById('starting_time').value" value="{{ $event->ending_time != null ? date('Y-m-d\TH:i:s', strtotime($event->ending_time)) : null }}"></div>


                    <div class="big-form-row">
                        <label class="big-form-label" for="offer_end">Sconto del %</label>
                        <input class="big-form-compact-field" type="number" id="offer_discount" name="offer_discount" placeholder="sconto %" min="1" max="100"
                               onchange="
                            if (this.value !== '') {
                                this.setAttribute('required', 'required');
                                document.getElementById('price').setAttribute('required', 'required');
                                document.getElementById('offer_start').setAttribute('required', 'required');
                            } else if (document.getElementById('offer_start').value === '') {
                                this.removeAttribute('required');
                                document.getElementById('price').removeAttribute('required');
                                document.getElementById('offer_start').removeAttribute('required');
                            }
                         "
                               @if($event->offer != null)
                                value="{{ 100 - $event->offer->discount }}"
                               @endif
                               @if( $event->offer != null && ($event->offer->discount != null || $event->offer->start != null ))
                               required
                            @endif
                        >
                    </div>
                    <div class="big-form-row">
                        <label class="big-form-label" for="offer_start">Data inizio offerta</label>
                        <input class="big-form-compact-field" type="datetime-local"
                               onfocus="this.max = document.getElementById('starting_time').value"
                               onchange="
                                    if (document.getElementById('offer_end').value !== '' && document.getElementById('offer_end').value != null && document.getElementById('offer_end').value < this.value) {
                                         document.getElementById('offer_end').value = this.value;
                                    } document.getElementById('offer_end').min = this.value;
                                    if (this.value !== '') {
                                        this.setAttribute('required', 'required');
                                        document.getElementById('price').setAttribute('required', 'required');
                                        document.getElementById('offer_discount').setAttribute('required', 'required');
                                    } else if (document.getElementById('offer_discount').value === '') {
                                        this.removeAttribute('required');
                                        document.getElementById('price').setAttribute('required', 'required');
                                        document.getElementById('offer_discount').removeAttribute('required');
                                    }
                               "
                               id="offer_start" name="offer_start"
                               value="{{ ( $event->offer != null && $event->offer->start != null) ? date('Y-m-d\TH:i:s', strtotime($event->offer->start)) : null }}"

                               @if( $event->offer != null && ($event->offer->discount != null || $event->offer->start != null) )
                                    required
                               @endif
                        >
                    </div>
                    <div class="big-form-row">
                        <label class="big-form-label" for="offer_end">Data fine offerta</label>
                        <input class="big-form-compact-field" type="datetime-local" id="offer_end" name="offer_end"
                               value="{{ ( $event->offer != null && $event->offer->end != null) ? date('Y-m-d\TH:i:s', strtotime($event->offer->end)) : null }}">
                    </div>


                    @if($event->images->isNotEmpty())
                    <div class="big-form-column" style="margin-top: 8px">
                        <label class="big-form-label" style="min-width: 400px">Immagini presenti</label>

                        <div id="images_edit_flex" style="width: 100%; display: flex; flex-direction: row; flex-wrap: wrap">


                            @foreach($event->images as $image)
                                <div style="width: calc(25% - 10px); height: 180px; position: relative; margin: 4px">
                                    <input type="checkbox" onchange="
                                        if (this.checked) {
                                            document.getElementById('image-disabled-transparent-overlay_{{$image->id}}').style.zIndex = 0;
                                        } else {
                                            document.getElementById('image-disabled-transparent-overlay_{{$image->id}}').style.zIndex = 2;
                                        }
                                    " name="selected_images[]" style="z-index: 3; transform : scale(1.8); position: absolute; right: 5px; top: 8px" value="{{$image->id}}" checked>
                                    <div class="uploaded-image-preview" id="image-disabled-transparent-overlay_{{$image->id}}"
                                         style="z-index: 0; background: rgba(213,213,213,0.5); width: 100%; height: 100%; margin: 0; position: absolute"></div>
                                    <img style="display: block; z-index: 1; width: 100%; height: 100%; margin: 0; position: absolute"
                                         class="uploaded-image-preview" id="image_{{$image->id}}" src="/storage/images/{{$image->file_name}}"
                                         alt="image-stock">
                                </div>
                            @endforeach

                        </div>
                    </div>
                    @endif


                    <div class="big-form-column" style="margin-top: 8px">
                        <label class="big-form-label" style="min-width: 400px" for="upload-label">Carica nuove
                            immagini</label>
                        <div id="images_add_flex" style="width: 100%; display: flex; flex-direction: row; flex-wrap: wrap">
                            <label style="margin-left: auto; margin-top: auto; margin-right: 4px" id="upload-label"
                                   class="custom-file-upload">
                                <input type="file" name="added_images[]" multiple="multiple" accept="image/*"
                                       onchange="
                                                var images_add_flex = document.getElementById('images_add_flex');
                                                upload_button = document.getElementById('upload-label');
                                                images_add_flex.innerHTML = '';
                                                for (let i = 0; i < files.length; i++) {
                                                     image_view_temp = document.createElement('img');
                                                     image_view_temp.className = 'uploaded-image-preview';
                                                     image_view_temp.src = window.URL.createObjectURL(files[i]);

                                                     images_add_flex.append(image_view_temp);
                                                }
                                                images_add_flex.append(upload_button);
                                           ">
                                Scegli immagini da aggiungere
                            </label>
                        </div>


                        <div class="big-form-column" style="margin-top: 8px">
                            <label class="big-form-label" style="min-width: 400px" for="upload-label">Seleziona categorie</label>
                            <div style="display: flex; flex-direction: row; flex-wrap: wrap; margin-bottom: 8px" >
                                @foreach($event->tags->sortBy('body') as $tag)

                                    <div style="display: flex; flex-direction: row; color: #0090E1; border: 2px solid #0090E1" class="category-oval" id="oval_{{ $tag->id }}"
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
                                               onchange="document.getElementById('preferences').submit()" checked>
                                        <label style="margin-right: 3px; -moz-user-select: none;-khtml-user-select: none;-webkit-user-select: none;-ms-user-select: none;
                                                    user-select: none;"
                                               class="checkbox-selection-item-label" for="categories[]">{{ $tag->body }}</label>
                                    </div>

                                @endforeach

                                @foreach(\App\Models\Tag::orderBy('body')->get()->diff($event->tags) as $tag)

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




                        <button class="big-form-submit-button" type="submit" value="Applica modifiche">Applica
                            modifiche
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>


@endsection
