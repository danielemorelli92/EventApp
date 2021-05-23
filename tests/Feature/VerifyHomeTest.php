<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class VerifyHomeTest extends TestCase
{

    use RefreshDatabase;

    public function test_in_evidenza_event_page_can_be_rendered(){

        $response = $this->get('/events-highlighted?'); // richiesta get da parte di guest

        $response->assertStatus(200);
    }
    public function test_a_user_can_visualize_12_events_sorted_by_data_and_distance(){

        Event::factory(15)->create();
        $html_content = $this->get('/events-highlighted?')->content();  //estraggo la pagina html visualizzata dall'utente
        $count = 0; // contiene quanti eventi vengono visualizzati


        preg_match_all('/href="\/event\/\d+"/', $html_content, $matches);
        $matches = array_map(function ($event) {
            preg_match('/\d+/', $event, $id);
            return $id[0];
        }, $matches[0]);
        // da qui in poi $matches conterrà la lista degli id degli eventi
        // che compaiono nella pagina (in base all'ordine in cui compaiono)
    }
}
