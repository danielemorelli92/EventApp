<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
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

Route::redirect('/events-highlighted', '/welcome');

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

Route::get('/events/create', [EventController::class, 'create'])->middleware(['auth'])->name('events.create');

Route::post('/events', [EventController::class, 'store'])->middleware(['auth'])->name('events.store');

Route::get('/event/{event}', [EventController::class, 'show'])->where('event', '[0-9]+');

Route::delete('/events/{event}', [EventController::class, 'destroy'])->where('event', '[0-9]+')->name('events.destroy');

Route::post('/registration', [EventRegistrationController::class, 'create']);

Route::get('/accetta/{event}',  [EventRegistrationController::class, 'show']);

Route::post('/delete-registration', [EventRegistrationController::class, 'delete']);

Route::get('/events/edit/{event}', [EventController::class, 'edit'])->where('event', '[0-9]+')->name('events.edit');

Route::put('/events/{event}', [EventController::class, 'update'])->where('event', '[0-9]+')->name('events.update');

Route::get('/request', [RequestController::class, 'create']);

Route::delete('/request/{request}', [RequestController::class, 'destroy']);

Route::post('/request', [RequestController::class, 'store']);

Route::get('/user-profile/{user}', [UserController::class, 'show']);

Route::delete('/permissions/{user}', [UserController::class, 'downgrade']); // cancella i permessi dati ad un organizzatore

Route::get('/notifications', function () {
    return view('notifications');
});
Route::post('/permissions/{user}', [UserController::class, 'upgrade']);

Route::get('/admin_page', [RequestController::class, 'show_list']);

Route::post('/comment/{event}/{comment}', [EventController::class, 'store_comment_reply'])->where('event', '[0-9]+')->where('comment', '[0-9]+');

Route::post('/comment/{event}', [EventController::class, 'store_comment'])->where('event', '[0-9]+');

Route::delete('/comment/{event}/{comment}', [EventController::class, 'destroy_comment']);

Route::put('/comment/{event}/{comment}', [EventController::class, 'update_comment']);

Route::delete('/image/{image}', [ImageController::class, 'destroy'])->where('image', '[0-9]+'); // cancella un immagine di un evento

require __DIR__ . '/auth.php';
