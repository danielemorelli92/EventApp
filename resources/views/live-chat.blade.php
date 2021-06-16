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
         style="height: auto;">
        <input type="search" placeholder="Cerca un utente...">
        @include('components.users-list')
    </div>
@endsection
