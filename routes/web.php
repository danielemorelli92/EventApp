<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use Illuminate\Support\Facades\Auth;
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
    if (Auth::check()) {
        return redirect('/dashboard');
    } else {
        return redirect('/events-highlighted');
    }
});

Route::get('/events', [EventController::class, 'index']);

Route::get('/events-highlighted', [EventController::class, 'indexHighlighted']);

Route::get('/event/{event}', [EventController::class, 'show']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::post('/registration', [EventRegistrationController::class, 'create']);

Route::post('/delete-registration', [EventRegistrationController::class, 'delete']);


require __DIR__ . '/auth.php';
