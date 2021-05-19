<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Models\{Event};

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

Route::get('/events', [EventController::class, 'index']);

Route::get('/events-highlighted', function () {
    return view('events-highlighted', [
        'events' => Event::all()
    ]);
});

Route::get('/event/{event}', [EventController::class, 'show']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
