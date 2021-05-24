<?php

namespace Tests\Feature;

use App\Models\{ExternalRegistration, Tag, User, Event};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonalAreaTest extends TestCase
{
    use RefreshDatabase;

    public function test_personal_area_can_be_rendered()
    {
        $response = $this->get('/dashboard'); // richiesta get da parte di guest
        $response->assertRedirect('/login'); // fixed
        $response = $this->actingAs(User::factory()->create())->get('/dashboard'); //richiesta get da utente autenticato
        $response->assertStatus(200);
    }

    public function test_registered_user_sees_events_where_is_registered()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'title' => 'evento a cui sei registrato'
        ]);
        $event2 = Event::factory()->create([
            'title' => 'non deve essere visto'
        ]);

        //  LOGGATO SI REGISTRA ALL'EVENTO
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->post('/registration', [
            'event' => $event->id
        ]);

        //SI SPOSTA ALL'AREA PERSONALE E CI SI ASPETTA CHE L'EVENTO APPAIA A SCHERMO
        $response = $this->get('/dashboard');
        $response->assertSeeText($event->title);
        $response->assertDontSeeText($event2->title);
    }

    public function test_personal_area_events_of_interest()
    {
        $eventOfInterest = Event::factory()->create();
        $categoryOfInterest = Tag::factory()->create();
        //TODO assegnare categoryOfInterest a eventOfInterest, e come gusto dell'utente
        $eventNotOfInterest = Event::factory()->create();
        //TODO assegnare una categoria a caso all'eventNotOfInterest

        $response = $this->get('/dashboard');
        $response->assertSee($eventOfInterest->title);
        $response->assertSee('/event/' . $eventOfInterest->id);
        $response->assertDontSee($eventNotOfInterest->title);
    }

    //TODO test sul calendario, sulla lista dei gusti e sulla modifica del profilo
}
