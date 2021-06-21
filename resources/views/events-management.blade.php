@extends('layouts.layout-header-two-columns')


@section('content')
    <div class="main-content-column">
        <div class="section-title" style="margin-left: 12px">I miei eventi</div>
        <div class="events-list">
            @foreach($my_events as $event)
                @include('components.event-rectangle-container')
            @endforeach
        </div>
    </div>

    <div class="right-side-column">
        @auth
            @if (!Gate::allows('create-request'))
                <form action="/events/create">
                    <button type="submit" style="width: 100%" value="Crea evento">Crea evento</button>
                </form>
            @else
                    <button type="submit" style="width: 100%" value="Non puoi creare eventi" disabled>Non puoi creare eventi</button>

            @endif
        @endauth

        <form id="preferences" action="/events/manage" method="get" style="display: flex; flex-direction: column;">
            @csrf
            <label class="section-title">Filtro data</label>
            <div class="radio-selection-item">
                @if($selected_date_filter == '' || $selected_date_filter == 'any')
                    <input type="radio" checked onchange="document.getElementById('preferences').submit()"
                           class="radio-selection-item-radio" name="date-filter-selection" value="any">
                @else
                    <input type="radio" onchange="document.getElementById('preferences').submit()"
                           class="radio-selection-item-radio" name="date-filter-selection" value="any">
                @endif
                <label for="date-filter-selection" class="radio-selection-item-label">Qualunque</label>
            </div>
            <div class="radio-selection-item">
                @if($selected_date_filter == 'past')
                    <input type="radio" checked onchange="document.getElementById('preferences').submit()"
                           class="radio-selection-item-radio" name="date-filter-selection" value="past">
                @else
                    <input type="radio" onchange="document.getElementById('preferences').submit()"
                           class="radio-selection-item-radio" name="date-filter-selection" value="past">
                @endif
                <label for="date-filter-selection" class="radio-selection-item-label">Passato</label>
            </div>
            <div class="radio-selection-item">
                @if($selected_date_filter == 'today')
                    <input type="radio" checked onchange="document.getElementById('preferences').submit()"
                           class="radio-selection-item-radio" name="date-filter-selection" value="today">
                @else
                    <input type="radio" onchange="document.getElementById('preferences').submit()"
                           class="radio-selection-item-radio" name="date-filter-selection" value="today">
                @endif
                <label for="date-filter-selection" class="radio-selection-item-label">Oggi</label>
            </div>
            <div class="radio-selection-item">
                @if($selected_date_filter == 'tomorrow')
                    <input type="radio" checked onchange="document.getElementById('preferences').submit()"
                           class="radio-selection-item-radio" name="date-filter-selection" value="tomorrow">
                @else
                    <input type="radio" onchange="document.getElementById('preferences').submit()"
                           class="radio-selection-item-radio" name="date-filter-selection" value="tomorrow">
                @endif
                <label for="date-filter-selection" class="radio-selection-item-label">Domani</label>
            </div>
            <div class="radio-selection-item">
                @if($selected_date_filter == 'week')
                    <input type="radio" checked onchange="document.getElementById('preferences').submit()"
                           class="radio-selection-item-radio" name="date-filter-selection" value="week">
                @else
                    <input type="radio" onchange="document.getElementById('preferences').submit()"
                           class="radio-selection-item-radio" name="date-filter-selection" value="week">
                @endif
                <label for="date-filter-selection" class="radio-selection-item-label">Questa settimana</label>
            </div>
            <div class="radio-selection-item">
                @if($selected_date_filter == 'month')
                    <input type="radio" checked onchange="document.getElementById('preferences').submit()"
                           class="radio-selection-item-radio" name="date-filter-selection" value="month">
                @else
                    <input type="radio" onchange="document.getElementById('preferences').submit()"
                           class="radio-selection-item-radio" name="date-filter-selection" value="month">
                @endif
                <label for="date-filter-selection" class="radio-selection-item-label">Questo mese</label>
            </div>
        </form>
    </div>


@endsection
