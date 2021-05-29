<?php

namespace Tests\Feature;

use App\Http\Controllers\EventController;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EventManagementTest extends TestCase
{
    public function test_a_organizer_can_see_the_create_event_form()
    {
        $user = User::factory()->create(); // crea l'utente

        $user->type = 'organizzatore';
        DB::table('users')
            ->where('email', $user->email)
            ->update(['type' => 'organizzatore']); // upgrade a organizzatore

        $request = $this->actingAs($user)->get('/events/create'); // richiesta form per la creazione eventi

        $request->assertOk();  // controlla se è stata ricevuta
    }

    public function test_a_normal_user_cannot_see_the_create_event_form()
    {
        $user = User::factory()->create();  // utente non organizzatore

        // tenta di accedere alla pagina di creazione eventi con un utente
        // non abilitato a farlo
        $request = $this->actingAs($user)->get('/events/create');

        $request->assertStatus(401);  // riceve l'errore: "401 - Unauthorized; Access denied"
    }

    public function test_a_organizer_can_create_an_event()
    {
        $user = User::factory()->create(); // crea l'utente

        $user->type = 'organizzatore'; // upgrade locale a organizzatore
        DB::table('users')
            ->where('email', $user->email)
            ->update(['type' => 'organizzatore']); // upgrade sul database a organizzatore

        $event = Event::factory()->make(); // crea un evento locale

        $request = $this->actingAs($user)->post('/events', $event->toArray());

        $request->assertSuccessful();

    }

    public function test_a_normal_user_cannot_create_an_event()
    {
        $user = User::factory()->create(); // crea l'utente

        $event = Event::factory()->make(); // crea un evento locale

        $request = $this->actingAs($user)->post('/events', $event->toArray());

        $request->assertStatus(401);
    }


    public function test_a_user_can_delete_a_own_event()
    {
        $user = User::factory()->hasCreatedEvents(1)->create(); // crea un utente con un evento già creato

        $event = $user->createdEvents->first(); // l'evento creato precedentemente

        $request = $this->actingAs($user)->delete('/events/' . $event->id); // richiede la cancellazione dell'evento

        $request->assertSuccessful(); // cancellazione avvenuta con successo
    }

    public function test_a_user_cannot_delete_a_event_of_someone_else()
    {
        $user_without_events = User::factory()->create(); // crea un utente
        $user_with_event = User::factory()->hasCreatedEvents(1)->create(); // un altro utente con un evento

        $event = $user_with_event->createdEvents->first(); // l'evento di un altro utente

        // richiede la cancellazione di un evento non suo
        $request = $this->actingAs($user_without_events)->delete('/events/' . $event->id);

        $request->assertStatus(401);  // riceve l'errore: "401 - Unauthorized; Access denied"
    }

    public function test_a_user_can_modify_a_own_event()
    {
        $user = User::factory()->hasCreatedEvents(1)->create();
        $event = $user->createdEvents->first();

        $event->title = 'new title';

        $request = $this->actingAs($user)->put('/events/' . $event->id, $event->toArray());

        $request->assertSuccessful();
    }

    public function test_a_user_cannot_modify_a_event_of_someone_else()
    {
        $user_without_events = User::factory()->create();
        $user_with_event = User::factory()->hasCreatedEvents(1)->create();
        $event = $user_with_event->createdEvents->first();

        $event->title = 'new title';

        $request = $this->actingAs($user_without_events)->put('/events/' . $event->id, $event->toArray());

        $request->assertStatus(401);
    }
}
