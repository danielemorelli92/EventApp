@extends('layouts.layout-header-two-columns-no-scroll')

@section('content')
    <div class="main-content-column"
         style="padding: 0; display: flex; flex-direction: column; width: auto; height: auto;"
    >
        @include('components.chat-header')
        @include('components.messages-area')
        @include('components.text-field-area')
    </div>
    <div class="right-side-column"
         style="height: auto; width: auto; padding: 0">
        <input type="search" style="margin: 8px" placeholder="Cerca un utente...">
        @include('components.contacts-list')
    </div>
@endsection
