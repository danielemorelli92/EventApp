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

Route::redirect('/events-highlighted', '/');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    } else {
        return redirect('/welcome');
    }
});

Route::get('/welcome', function () {
    $events = Event::query()->where('starting_time', '>=', date(now()))->orderBy('starting_time')->get();
    $events = $events->filter(function ($event) {
        return $event->getDistanceToMe() <= 25;
    });

    return view('events-highlighted', [
        'events' => $events
    ]);
});

Route::get('/dashboard', [EventController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

Route::post('/dashboard', [EventController::class, 'dashboard'])->middleware(['auth']);

Route::get('/events', [EventController::class, 'index'])->name('events.index');

Route::get('/events/manage', [EventController::class, 'manage'])->middleware(['auth'])->name('events.manage');

Route::get('/events/create', [EventController::class, 'create'])->name('events.create');

Route::post('/events', [EventController::class, 'store'])->name('events.store');

Route::get('/event/{event}', [EventController::class, 'show'])->where('event', '[0-9]+');

Route::post('/registration', [EventRegistrationController::class, 'create']);

Route::post('/delete-registration', [EventRegistrationController::class, 'delete']);


require __DIR__ . '/auth.php';
