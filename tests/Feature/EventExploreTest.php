<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventExploreTest extends TestCase
{
    public function test_a_user_can_access_the_explore_event_page()
    {
        $response = $this->get('/events'); // richiesta get da parte di guest

        $response->assertStatus(200);

        $response = $this->actingAs(User::factory()->create())->get('/events'); //richiesta get da utente autenticato

        $response->assertStatus(200);
    }

    public function test_a_user_can_select_a_event()
    {
        $html_content = $this->get('/events')->content(); //estraggo la pagina html visualizzata dall'utente
        $matches = []; // conterrà eventuali match delle regex
        preg_match('/<a.*?href="\/event\/\d+">/', $html_content, $matches); //c'è almeno un link agli eventi?
        $this->assertGreaterThan(0, count($matches), 'Non vengono visualizzati eventi');
        // verifica che ci sia almeno un link a evento cliccabile
    }

}
