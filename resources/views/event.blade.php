@extends('layouts.layout-header-three-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')


    <div class="left-side-column">
        <div style="display: flex; align-items: center; flex-direction: row">
            <div style="margin-left: 8px; background-color: green; width: 16px; height: 16px"></div>
            <div class="section-title">torna a lista eventi</div> <!-- TODO cambiare stile -->
        </div>
        <div class="section-title">Immagini</div>
        <div class="event-images-list">
            <div class="event-images-item"></div>
        </div>
    </div>

    <div class="main-content-column">
        <div class="title">Event title</div>
        <div class="section-title">Descrizione</div>
        <div class="text-area">Lorem ipsum dolor sit amet, propriae luptatum ut usu, an doctus delicatissimi qui, eam everti theophrastus ea. Nec ex error noluisse. Ne idque erroribus deterruisset nam. Sea alii dolor ut. Dico nibh everti ei qui, ad error partiendo sea. Ut est ridens veritus, no virtute vivendum vis, vel illum detracto ad.
            Periculis temporibus sea in, cu dicam interesset has, bonorum adipiscing mei et. Ea his alia facilisi, sumo partiendo efficiantur per at, nibh semper maluisset ex usu. Quo eu homero eripuit invenire, ex qui solet legere tincidunt. Et nostro impetus feugiat mei, sed magna ornatus menandri ei. Ne pro soluta ignota scribentur, soleat causae melius qui ut.
            Mei in dicam laudem interesset. Pri maiestatis argumentum omittantur id, duo viris mnesarchum an. Ea amet dicit cum, duo melius oblique philosophia te. Eum eu minim disputando. His ei alii iracundia, no justo libris quo.
        </div>
        <div style="width: auto; height: min-content; display: flex; flex-wrap: wrap; margin: 8px">
            <div class="category-oval">Category</div>
        </div>
    </div>

    <div class="right-side-column">
        <div class="section-title">Informazioni evento</div>
        <div class="event-info-box">

        </div>
        <button style="margin-top: auto">Registrati</button>
        <button>Aggiungi al calendario</button>

    </div>
    </div>
@endsection
