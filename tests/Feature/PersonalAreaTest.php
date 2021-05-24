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

        $this->post('/registration', [
            'event' => $event->id
        ]);

        //SI SPOSTA ALL'AREA PERSONALE E CI SI ASPETTA CHE L'EVENTO APPAIA A SCHERMO
        $response = $this->get('/dashboard');
        $response->assertSeeText($event->title);
        $response->assertDontSeeText($event2->title);
    }

    // Un utente deve poter visualizzare le proprie categorie di interesse scelte dall’area personale.
    public function test_a_user_can_view_his_selected_interests_on_his_page()
    {
        //<input type="checkbox" name="tags[]" value="{{ $tag->id }}" checked>{{ $tag->body }}</input>
        // regex= "/\<input type="checkbox".+?value="\d+" (checked)?\>/"
        $user = User::factory()->create();
        $request = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $html_page = $request->content();


    }
}
