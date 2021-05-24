<?php

namespace Tests\Feature;

use App\Models\{ExternalRegistration, User, Event};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventExploreTest extends TestCase
{
    use RefreshDatabase;

    public function test_explore_event_page_can_be_rendered()
    {
        $response = $this->get('/events'); // richiesta get da parte di guest

        $response->assertStatus(200);

        $response = $this->actingAs(User::factory()->create())->get('/events'); //richiesta get da utente autenticato

        $response->assertStatus(200);
    }

    public function test_a_user_can_select_a_event()
    {
        Event::factory(10)->create();
        $html_content = $this->get('/events')->content(); //estraggo la pagina html visualizzata dall'utente
        $matches = []; // conterrà eventuali match delle regex
        preg_match('/<a.*?href="\/event\/\d+">/', $html_content, $matches); //c'è almeno un link agli eventi?
        $this->assertGreaterThan(0, count($matches), 'Non vengono visualizzati eventi');
        // verifica che ci sia almeno un link a evento cliccabile
    }

    public function test_a_user_can_search_a_event_by_title()
    {
        $eventSearched = Event::factory()->create([
            'title' => 'matched'
        ]);
        $eventNotSerched = Event::factory()->create([
            'title' => 'do not show'
        ]);

        $response = $this->get('/events', [
            'search' => 'matched'
        ]);
        $response->assertSee('matched');
        //$response->assertDontSee('do not show');
        $response->assertDontSeeText('do not show');
    }

    public function test_event_page_can_be_rendered()
    {
        $event = Event::factory()->create();
        $response = $this->get('/event/' . $event->id);
        $response->assertStatus(200);
    }

    public function test_a_user_can_access_the_event_page_from_the_events_list_in_explore_events_page()
    {
        $event = Event::factory()->create();
        $response = $this->get('/events');
        $response->assertSee($event->title);
        $response->assertSee('/event/' . $event->id);
    }

    public function test_a_user_can_register_to_a_event()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();

        // NON LOGGATO
        $response = $this->get('/event/' . $event->id);
        $response->assertSee('Registrati');
        // vede il tasto registrati, si registra, controllare che nella lista dei registrati c'è l'utente
        $response = $this->post('/registration', [
            'event' => $event->id,
            'cf' => 'codicefiscalefake'
        ]);
        $externalRegistration = $event->externalRegistrations->first();
        $this->assertEquals('codicefiscalefake', $externalRegistration->cf);

        //  LOGGATO
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response = $this->get('/event/' . $event->id);
        $response->assertSee('Registrati');
        $response = $this->post('/registration', [
            'event' => $event->id
        ]);
        $registeredUsers = $event->users;
        $registeredUsers->contains($user);
    }

//Un utente può cercare in base a distanza massima.
    public function test_a_user_can_search_by_distance()
    {

    }

//Un utente può cercare in base data massima dell’evento.
    public function test_a_user_can_search_by_date_max()
    {

    }

//Un utente può cercare in base a delle categorie.
    public function test_a_user_by_category()
    {

    }
}
