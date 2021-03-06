<?php

namespace Tests\Feature;

use App\Http\Controllers\EventController;
use App\Models\Event;
use App\Models\Image;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
            'registration_link' => 'none',
            'city' => 'Roseto',
            'starting_time' => '2021-09-11 12:30',
            'ending_time' => null
        ]; // crea un evento locale

        $this->assertCount(0, Event::all());

        $request = $this->actingAs($user)->post('/events', $event);

        $this->assertCount(1, Event::all());
        $this->assertEquals($user->id, Event::all()->first()->author_id);
    }
    public function test_a_organizer_can_create_a_valid_offer_for_event()
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

        $valid_data = [
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
            'registration_link' => 'none',
            'city' => 'Roseto',
            'starting_time' => '2021-09-11 12:30',
            'ending_time' => null,

            'offer_start' => '2021-09-09 12:30',
            'offer_end' => '2021-09-11 12:30',
            'offer_discount' => 70
        ]; // crea un evento locale

        $this->assertCount(0, Event::all());

        $request = $this->actingAs($user)->post('/events', $valid_data);

        $this->assertCount(1, Event::all(), 'creazione evento fallita');
        $this->assertNotNull(Event::all()->first()->offer, 'creazione offerta fallita');
        $this->assertEquals('2021-09-09 12:30:00', Event::all()->first()->offer->start, "l'offerta non ha il valore di inizio corretto");
        $this->assertEquals('2021-09-11 12:30:00', Event::all()->first()->offer->end, "l'offerta non ha il valore di fine corretto");
        $this->assertEquals(30, Event::all()->first()->offer->discount, "l'offerta non ha il valore di sconto corretto");
    }
    public function test_a_organizer_cant_create_invalid_offer_for_event()
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

        $valid_data = [
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
            'registration_link' => 'none',
            'city' => 'Roseto',
            'starting_time' => '2021-09-11 12:30',
            'ending_time' => null,

            'offer_start' => '2051-09-09 12:30',
            'offer_end' => '2031-09-11 12:30',
            'offer_discount' => 120
        ]; // crea un evento locale

        $this->assertCount(0, Event::all());

        $request = $this->actingAs($user)->post('/events', $valid_data);

        $this->assertCount(0, Event::all(), 'creato evento invalido');
        if (Event::all()->first() != null && Event::all()->first()->offer != null) {
            $this->assertNotEquals('2051-09-09 12:30:00', Event::all()->first()->offer->start, "l'offerta ha un valore di inizio invalido");
            $this->assertEquals('2031-09-11 12:30', Event::all()->first()->offer->end, "l'offerta ha un valore di fine invalido");
            $this->assertNotEquals(120, Event::all()->first()->offer->discount, "l'offerta ha un valore di sconto non valido");
        }
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
            'registration_link' => 'none',
            'city' => 'Roseto',
            'starting_time' => '2021-09-11 12:30',
            'ending_time' => null
        ];

        $this->assertCount(0, Event::all());

        $request = $this->actingAs($user)->post('/events', $event);

        $this->assertCount(0, Event::all());
    }

    public function test_a_organizer_cant_create_event_with_empty_registration_link_when_redirecting_users()
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

        $event1 = [
            'title' => 'A fake event!',
            'description' => 'A very very very fake event...',
            'author_id' => $user->id,
            'type' => 'Concert',
            'max_partecipants' => '250',
            'price' => 100,
            'latitude' => 56.72932400,
            'longitude' => -20.48122800,
            'ticket_office' => '',
            'website' => 'http://www.best-website-ever.com/',
            'external_registration' => 'ticket_office',
            'city' => 'Roseto',
            'starting_time' => '2021-09-11 12:30',
            'ending_time' => null
        ]; // crea un evento locale

        $this->actingAs($user)->post('/events', $event1);

        $this->assertCount(0, Event::all(), "l'organizzatore ha creato con successo un evento con registrazione esterna su ticket office senza specificarne l'URL.");

        $event2 = [
            'title' => 'A fake event!',
            'description' => 'A very very very fake event...',
            'author_id' => $user->id,
            'type' => 'Concert',
            'max_partecipants' => '250',
            'price' => 100,
            'latitude' => 56.72932400,
            'longitude' => -20.48122800,
            'ticket_office' => 'http://www.best-website-ever.com/buy',
            'website' => '',
            'external_registration' => 'website',
            'city' => 'Roseto',
            'starting_time' => '2021-09-11 12:30',
            'ending_time' => null
        ]; // crea un evento locale
        $this->actingAs($user)->post('/events', $event2);

        $this->assertCount(0, Event::all(), "l'organizzatore ha creato con successo un evento con registrazione esterna su website senza specificarne l'URL.");
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
            'city' => 'old city',
            'starting_time' => date(now()->setSeconds(0)),
            'ending_time' => date(now()->setSeconds(0)),
            'author_id' => $user->id,
        ]);

        $request = $this->actingAs($user)->put('/events/' . $event->id, [
            'title' => 'new title'
        ]);
        $updated_event = $event->fresh();
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
            'city' => 'new city'
        ]);
        $updated_event->refresh();
        self::assertEquals('new city', $updated_event->city, "l'indirizzo dell'evento non è stato modificato");

        $new_date = date(now()->setSeconds(0)->addWeek());
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

    public function test_a_user_can_edit_event_offer_when_data_valid()
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
            'city' => 'old city',
            'starting_time' => '2031-09-09 12:30',
            'ending_time' => '2031-09-10 12:30',
            'author_id' => $user->id,
        ]);

        Offer::create([
            'event_id' => $event->id,
            'start' => '2021-09-09 12:30',
            'end' => '2021-09-11 12:30',
            'discount' => 70
        ]);
        $request = $this->actingAs($user)->put('/events/' . $event->id, [
            'price' => 10.0,
            'offer_start' => '2031-08-09 12:30',
            'offer_end' => '2031-08-11 12:30',
            'offer_discount' => 50
        ]);
        $updated_event = $event->fresh();

        $this->assertNotNull(Event::all()->first()->offer, 'creazione offerta fallita');
        $this->assertEquals('2031-08-09 12:30:00', Event::all()->first()->offer->start, "l'offerta non ha il valore di inizio corretto dopo la prima modifica");
        $this->assertEquals('2031-08-11 12:30:00', Event::all()->first()->offer->end, "l'offerta non ha il valore di fine corretto dopo la prima modifica");
        $this->assertEquals(50, Event::all()->first()->offer->discount, "l'offerta non ha il valore di sconto corretto dopo la prima modifica");


        $request = $this->actingAs($user)->put('/events/' . $event->id, [
            'offer_start' => '2051-08-09 12:30',
            'offer_end' => '2031-08-11 12:30',
            'offer_discount' => 120
        ]);
        $this->assertEquals('2031-08-09 12:30:00', Event::all()->first()->offer->start, "l'offerta ha cambiato valore di inizio quando non doveva");
        $this->assertEquals('2031-08-11 12:30:00', Event::all()->first()->offer->end, "l'offerta non ha il valore di fine corretto");
        $this->assertEquals(50, Event::all()->first()->offer->discount, "l'offerta ha cambiato valore di sconto quando non doveva");
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
            'city' => 'old city',
            'starting_time' => date(now()->setSeconds(0)),
            'ending_time' => date(now()->setSeconds(0))
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
            'city' => 'new city'
        ]);
        $new_date = date(now()->setSeconds(0)->addWeek());
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


    public function test_an_event_admin_can_delete_an_image()
    {
        $user = User::factory()->create();

        $user->type = 'organizzatore';

        DB::table('users')
            ->where('email', $user->email)
            ->update(['type' => 'organizzatore']);

        $event = Event::factory()->create([
            'author_id' => $user->id
        ]);

        $image1 = Image::factory()->create([
            'event_id' => $event->id
        ]);

        $this->assertTrue($event->getImages()->contains($image1), "l'immagine 1 non è stata caricata nel DB");

        $this->actingAs($user)->delete("/image/" . $image1->id); // ROUTE chiamata dall'organizzatore, per fare in modo che cancelli una immagine
        $event->refresh();

        $this->assertFalse($event->getImages()->contains($image1), "l'immagine 1 non è stata eliminata nel DB");
    }

    public function test_a_user_cannot_delete_an_image_of_someone_else()
    {
        $user = User::factory()->create();
        $user->type = 'organizzatore';
        $user_unauthorized = User::factory()->create();

        DB::table('users')
            ->where('email', $user->email)
            ->update(['type' => 'organizzatore']);

        $event = Event::factory()->hasImages(1)->create([
            'author_id' => $user->id
        ]);

        $image = $event->images->first();
        $this->actingAs($user_unauthorized)->delete("/image/" . $image->id);
        $event->refresh();
        $this->assertNotNull($event->images->first(), "utente non autorizzato ha eliminato l'immagine");
    }
}
