<?php

namespace Tests\Feature;

use App\Http\Controllers\EventController;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EventManagementTest extends TestCase
{
    use RefreshDatabase;


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
        $user = User::create([
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
            'name' => 'Giovanni Giorgio'
        ]); // crea l'utente

        $user->type = 'organizzatore'; // upgrade locale a organizzatore
        DB::table('users')
            ->where('email', $user->email)
            ->update(['type' => 'organizzatore']); // upgrade sul database a organizzatore

        $event = [
            'title' => 'A fake event!',
            'description' => 'A very very very fake event...',
            'author_id' => $user->id,
            'type' => 'Concert',
            'max_partecipants' => '250',
            'price' => 100,
            'latitude' => 56.72932400,
            'longitude' => -20.48122800,
            'ticket_office' => 'http://www.ticket-office.com/',
            'website' => 'http://www.best-website-ever.com/',
            'address' => 'Via di casa mia, 77',
            'starting_time' => '2021-09-11 12:30',
            'ending_time' => null
        ]; // crea un evento locale

        $this->assertCount(0, Event::all());

        $request = $this->actingAs($user)->post('/events', $event);

        $this->assertCount(1, Event::all());
        $this->assertEquals($user->id, Event::all()->first()->author_id);
    }

    public function test_a_normal_user_cannot_create_an_event()
    {
        $user = User::factory()->create(); // crea l'utente

        $event = [
            'title' => 'A fake event!',
            'description' => 'A very very very fake event...',
            'author_id' => $user->id,
            'type' => 'Concert',
            'max_partecipants' => '250',
            'price' => 100,
            'latitude' => 56.72932400,
            'longitude' => -20.48122800,
            'ticket_office' => 'http://www.ticket-office.com/',
            'website' => 'http://www.best-website-ever.com/',
            'address' => 'Via di casa mia, 77',
            'starting_time' => '2021-09-11 12:30',
            'ending_time' => null
        ];

        $this->assertCount(0, Event::all());

        $request = $this->actingAs($user)->post('/events', $event);

        $this->assertCount(0, Event::all());
    }


    public function test_a_user_can_delete_a_own_event()
    {
        $user = User::factory()->hasCreatedEvents(1)->create(); // crea un utente con un evento già creato

        $event = $user->createdEvents->first(); // l'evento creato precedentemente

        $this->assertCount(1, Event::all()->where('author_id', '=', $user->id));

        $request = $this->actingAs($user)->delete('/events/' . $event->id); // richiede la cancellazione dell'evento

        $request->assertSessionHasNoErrors();
    }

    public function test_a_user_cannot_delete_a_event_of_someone_else()
    {
        $user_without_events = User::factory()->create(); // crea un utente

        $user_with_event = User::factory()->hasCreatedEvents(1)->create(); // un altro utente con un evento
        $event = $user_with_event->createdEvents->first(); // l'evento di un altro utente

        $this->assertCount(1, Event::all()->where('author_id', '=', $user_with_event->id));

        // richiede la cancellazione di un evento non suo
        $request = $this->actingAs($user_without_events)->delete('/events/' . $event->id);

        $this->assertCount(1, Event::all()->where('author_id', '=', $user_with_event->id));
    }

    public function test_a_user_can_edit_a_own_event()
    {
        $user = User::factory()->create();

        $event = Event::factory()->create([
            'author_id' => $user->id,
        ]);

        $request = $this->actingAs(User::find($user->id))->put('/events/' . $event->id, [
            'title' => 'new title'
        ]);

        $request->assertSessionHasNoErrors();
    }

    public function test_a_user_cannot_edit_a_event_of_someone_else()
    {
        $user_without_events = User::factory()->create();
        $user_with_event = User::factory()->hasCreatedEvents(1)->create();
        $event = $user_with_event->createdEvents->first();

        $old_title = $event->title;

        $request = $this->actingAs(User::find($user_without_events->id))->put('/events/' . $event->id, [
            'title' => 'new title'
        ]);

        $this->assertEquals($old_title, Event::all()->first()->title);
    }

    public function test_a_organizer_can_view_the_events_management_page()
    {
        $user = User::factory()->create(); // crea l'utente

        $user->type = 'organizzatore'; // upgrade locale a organizzatore
        DB::table('users')
            ->where('email', $user->email)
            ->update(['type' => 'organizzatore']); // upgrade sul database a organizzatore

        $request = $this->actingAs($user)->get('/events/manage');

        $request->assertOk();
    }

    public function test_a_normal_user_cannot_view_the_events_management_page()
    {
        $user = User::factory()->create(); // crea l'utente

        $request = $this->actingAs($user)->get('/events/manage');

        $request->assertStatus(401);
    }

    public function test_a_user_cannot_register_to_a_event() //raggiunto numero max di iscritti
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();

    }
}
