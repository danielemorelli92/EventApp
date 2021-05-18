@extends('layouts.layout-header-two-columns')

@section ('style')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/events.css') }}"
@endsection

@section('content')
    <div class="main-content-column">
        <div class="section-title">Eventi a cui sei registrato</div>
        <div class="events-list">
            <!-- TODO foreach -->
            <?php
            include resource_path('views\components\event-square.blade.php');
            ?>
        </div>
        <div class="section-title">Eventi che hai visualizzato</div>
        <div class="events-list">
            <!-- TODO foreach -->
            <?php
            include resource_path('views\components\event-square.blade.php');
            ?>
        </div>
    </div>

    <div class="right-side-column">
        <div class="section-title">Filtro distanza/data</div>
        <div class="events-parameters-selection-box"></div>
        <div class="section-title">Filtra per interesse</div>
        <div class="categories-selection-box">
        </div>
    </div>
@endsection
<!--<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                You're logged in!
            </div>
        </div>
    </div>
</div>
</x-app-layout>-->
