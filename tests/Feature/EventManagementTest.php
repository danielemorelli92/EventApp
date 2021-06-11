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

        $request = $this->actingAs($user)->delete('/events/' . $event->id); // richiede la cancellazione dell'evento

        self::assertNull(Event::find($event->id), "l'evento non è stato cancellato");
    }

    public function test_a_user_cannot_delete_a_event_of_someone_else()
    {
        $user_without_events = User::factory()->create(); // crea un utente

        $user_with_event = User::factory()->hasCreatedEvents(1)->create(); // un altro utente con un evento
        $event = $user_with_event->createdEvents->first(); // l'evento di un altro utente

        // richiede la cancellazione di un evento non suo
        $request = $this->actingAs($user_without_events)->delete('/events/' . $event->id);

        self::assertNotNull(Event::find($event->id), "l'evento è stato cancellato da un utente non proprietario");
    }

    public function test_a_user_can_edit_a_own_event()
    {
        $user = User::factory()->create();

        $event = Event::factory()->create([
            'title' => 'old title',
            'description' => 'old description',
            'type' => 'old type',
            'max_partecipants' => 10,
            'price' => 10.0,
            'ticket_office' => 'old url',
            'website' => 'old url',
            'address' => 'old address',
            'starting_time' => date(now()),
            'ending_time' => date(now()),
            'author_id' => $user->id,
        ]);

        $request = $this->actingAs($user)->put('/events/' . $event->id, [
            'title' => 'new title'
        ]);
        $updated_event = Event::find($event->id);
        self::assertEquals('new title', $updated_event->title, "il titolo dell'evento non è stato modificato");

        $request = $this->actingAs($user)->put('/events/' . $event->id, [
            'description' => 'new description'
        ]);
        $updated_event->refresh();
        self::assertEquals('new description', $updated_event->description, "la descrizione dell'evento non è stata modificata");

        $request = $this->actingAs($user)->put('/events/' . $event->id, [
            'type' => 'new type'
        ]);
        $updated_event->refresh();
        self::assertEquals('new type', $updated_event->type, "il tipo di evento non è stato modificato");

        $request = $this->actingAs($user)->put('/events/' . $event->id, [
            'max_partecipants' => 20
        ]);
        $updated_event->refresh();
        self::assertEquals(20, $updated_event->max_partecipants, "il numero massimo di partecipanti all'evento non è stato modificato");

        $request = $this->actingAs($user)->put('/events/' . $event->id, [
            'price' => 20.0
        ]);
        $updated_event->refresh();
        self::assertEquals(20.0, $updated_event->price, "il prezzo del biglietto dell'evento non è stato modificato");

        $request = $this->actingAs($user)->put('/events/' . $event->id, [
            'ticket_office' => 'new url'
        ]);
        $updated_event->refresh();
        self::assertEquals('new url', $updated_event->ticket_office, "il sito del ticket office dell'evento non è stato modificato");

        $request = $this->actingAs($user)->put('/events/' . $event->id, [
            'website' => 'new url'
        ]);
        $updated_event->refresh();
        self::assertEquals('new url', $updated_event->website, "il sito web dell'evento non è stato modificato");

        $request = $this->actingAs($user)->put('/events/' . $event->id, [
            'address' => 'new address'
        ]);
        $updated_event->refresh();
        self::assertEquals('new address', $updated_event->address, "l'indirizzo dell'evento non è stato modificato");

        $new_date = date(now()->addWeek());
        $request = $this->actingAs($user)->put('/events/' . $event->id, [
            'starting_time' => $new_date
        ]);
        $updated_event->refresh();
        self::assertEquals($new_date, $updated_event->starting_time, "la data di inizio evento non è stata modificata");

        $request = $this->actingAs($user)->put('/events/' . $event->id, [
            'ending_time' => $new_date
        ]);
        $updated_event->refresh();
        self::assertEquals($new_date, $updated_event->ending_time, "la data di fine evento non è stata modificata");
    }

    public function test_a_user_cannot_edit_a_event_of_someone_else()
    {
        $user_without_events = User::factory()->create();
        $user_with_event = User::factory()->hasCreatedEvents(1)->create();

        $event = $user_with_event->createdEvents->first();
        $event->update([
            'title' => 'old title',
            'description' => 'old description',
            'type' => 'old type',
            'max_partecipants' => 10,
            'price' => 10.0,
            'ticket_office' => 'old url',
            'website' => 'old url',
            'address' => 'old address',
            'starting_time' => date(now()),
            'ending_time' => date(now())
        ]);

        $event->refresh();

        $request = $this->actingAs($user_without_events)->put('/events/' . $event->id, [
            'title' => 'new title'
        ]);
        $request = $this->actingAs($user_without_events)->put('/events/' . $event->id, [
            'description' => 'new description'
        ]);
        $request = $this->actingAs($user_without_events)->put('/events/' . $event->id, [
            'type' => 'new type'
        ]);
        $request = $this->actingAs($user_without_events)->put('/events/' . $event->id, [
            'max_partecipants' => 20
        ]);
        $request = $this->actingAs($user_without_events)->put('/events/' . $event->id, [
            'price' => 20.0
        ]);
        $request = $this->actingAs($user_without_events)->put('/events/' . $event->id, [
            'ticket_office' => 'new url'
        ]);
        $request = $this->actingAs($user_without_events)->put('/events/' . $event->id, [
            'website' => 'new url'
        ]);
        $request = $this->actingAs($user_without_events)->put('/events/' . $event->id, [
            'address' => 'new address'
        ]);
        $new_date = date(now()->addWeek());
        $request = $this->actingAs($user_without_events)->put('/events/' . $event->id, [
            'starting_time' => $new_date
        ]);
        $request = $this->actingAs($user_without_events)->put('/events/' . $event->id, [
            'ending_time' => $new_date
        ]);

        self::assertTrue($event->isClean(), "l'evento è stato modificato da un utente che non poteva farlo");
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

    public function test_a_logged_user_cannot_register_to_a_full_event() //raggiunto numero max di iscritti
    {

        $this->withoutExceptionHandling();
        $event = Event::factory()->hasRegisteredUsers(6)->hasExternalRegistrations(4)->create([
            'max_partecipants' => 10
        ]);
        $user = User::factory()->create();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->post('/registration', [
            'event' => $event->id,
        ]);
        $this->assertEquals(10, ($event->registeredUsers->count()) + ($event->externalRegistrations->count()), "l'utente loggato si è registrato ad un evento completo");

    }

    public function test_a_user_cannot_register_to_a_full_event() //raggiunto numero max di iscritti
    {
        $event = Event::factory()->hasRegisteredUsers(10)->hasExternalRegistrations(5)->create([
            'max_partecipants' => 15
        ]);
        $this->post('/registration', [
            'event' => $event->id,
            'cf' => 'codice123'
        ]);
        $this->assertEquals(15, ($event->registeredUsers->count()) + ($event->externalRegistrations->count()), "l'utente non loggato si è registrato ad un evento completo");
    }

    public function test_a_user_cannot_edit_acceptance_criteria()
    {
        $user = User::factory()->create();

        $event = Event::factory()->create([
            'criteri_accettazione' => 'questi sono i criteri',
            'author_id' => $user->id
        ]);

        $this->actingAs($user)->put('/events/' . $event->id, [
            'criteri_accettazione' => 'nuovo criterio'
        ]);

        $event->refresh();

        $this->assertEquals('questi sono i criteri', $event->criteri_accettazione, 'sono stati modificati i criteri');
    }
}
