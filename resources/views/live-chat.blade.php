@extends('layouts.layout-header-two-columns')

@section('content')
    <div class="main-content-column"
         style="
            width: calc(80vw + 8px);
            margin: 0;
            padding: 0;
            border-width: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: stretch;
            "
    >
        @include('components.chat-header')
        @include('components.chat-area')
        @include('components.message-area')
    </div>
    <div class="right-side-column"
         style="width: auto; max-height: calc(100vh - 62px - 35px);">
        <input type="search" placeholder="Cerca un utente...">
        @include('components.chat-list')
    </div>
@endsection
