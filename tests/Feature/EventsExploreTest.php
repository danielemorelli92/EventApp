<?php

namespace Tests\Feature;

use App\Models\{ExternalRegistration, User, Event, Tag};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventsExploreTest extends TestCase
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
        Event::factory(10)->create([
            'starting_time' => date(now()->addYear())
        ]);
        $html_content = $this->get('/events')->content(); //estraggo la pagina html visualizzata dall'utente
        preg_match_all('/<a.*?href="\/event\/\d+">/', $html_content, $matches); //c'è almeno un link agli eventi?
        $this->assertCount(10, $matches[0], 'qualche evento non viene visualizzato');
    }

    public function test_a_user_can_search_a_event_by_title_or_description()
    {
        $event_title_matched = Event::factory()->create([
            'title' => 'matched',
            'starting_time' => date(now()->addYear())
        ]);
        $event_description_matched = Event::factory()->create([
            'title' => 'another',
            'description' => 'matched',
            'starting_time' => date(now()->addYear())
        ]);
        $eventNotSerched = Event::factory()->create([
            'title' => 'do not show',
            'description' => 'do not show',
            'starting_time' => date(now()->addYear())
        ]);

        $response = $this->get('/events?search=matched');

        $response->assertSee($event_title_matched->title);
        $response->assertSee($event_description_matched->title);
        $response->assertDontSee($eventNotSerched->title);
    }

    public function test_event_page_can_be_rendered()
    {
        $event = Event::factory()->create();
        $response = $this->get('/event/' . $event->id);
        $response->assertStatus(200);
    }

    public function test_a_user_can_access_the_event_page_from_the_events_list_in_explore_events_page()
    {
        $event = Event::factory()->create([
            'starting_time' => date(now()->addYear())
        ]);
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
        $near_event = Event::factory()->create([
            'title' => 'si deve leggere questo',
            'latitude' => 42.5049, // coordinate vicine
            'longitude' => 14.1389, // (Montesilvano, circa 7km di distanza),
            'starting_time' => date(now()->addYear())
        ]);
        $far_event = Event::factory()->create([
            'title' => 'ma non questo qui',
            'latitude' => -42.25573,  // coordinate lontane
            'longitude' => 151.47322,  // (in mezzo all'oceano vicino l'Australia,
            //  circa 16500km di distanza. Perché sì.)
            'starting_time' => date(now()->addYear())
        ]);
        $response = $this->get('/events?dist-max=50');

        $response->assertSee($near_event->title);
        $response->assertDontSee($far_event->title);
    }

    //Un utente può cercare in base data massima dell’evento.
    public function test_a_user_can_search_by_date_max()
    {
        $today_event = Event::factory()->create([
            'title' => 'si deve leggere questo',
            'starting_time' => date(now()->addHours(5))  // un evento che inizia tra 5 ore
        ]);
        $next_year_event = Event::factory()->create([
            'title' => 'ma non questo qui',
            'starting_time' => date(now()->addYear())     // un evento che inizia l'anno prossimo
        ]);
        $response = $this->get('/events?data-max=tomorrow');

        $response->assertSee($today_event->title);
        $response->assertDontSee($next_year_event->title);
    }

    //Un utente può cercare in base a delle categorie.
    public function test_a_user_can_search_by_category()
    {
        $event_with_tag = Event::factory()->create([
            'starting_time' => date(now()->addYear())
        ]);
        $tag = Tag::factory()->create();
        $event_with_tag->tags()->attach($tag);
        $event_without_tag = Event::factory()->create([
            'starting_time' => date(now()->addYear())
        ]);

        $request = $this->get('/events?search=&categories%5B%5D=' . $tag->id . '+');


        $request->assertSee($event_with_tag->title);
        $request->assertDontSee($event_without_tag->title);
    }
}
