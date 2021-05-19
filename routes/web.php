<?php

use Illuminate\Support\Facades\Route;
use App\Models\{Event,Tag,User};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', function () {
    return view('home');
});
Route::get('/events', function () {
    return view('events', [
        'events' => Event::all(),
        'tags' => Tag::all()
    ]);
});
Route::get('/events-highlighted', function () {
    return view('events-highlighted');
});
Route::get('/event/{event}', function (Event $event) {
    return view('event', [
        'event' => $event
    ]);
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
