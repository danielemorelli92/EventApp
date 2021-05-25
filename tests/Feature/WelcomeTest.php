<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use function PHPUnit\Framework\isNull;


class WelcomeTest extends TestCase
{

    use RefreshDatabase;

    public function test_in_evidenza_event_page_can_be_rendered()
    {

        $response = $this->get('/events-highlighted?'); // richiesta get da parte di guest

        $response->assertStatus(200);
    }

    public function test_a_user_can_visualize_12_events_sorted_by_data_and_distance()
    {
        Event::factory(150)->create();

        $html_content = $this->get('/events-highlighted')->content();
        preg_match_all('/href="\/event\/\d+"/', $html_content, $matches);
        $actual = array_map(function ($event) {
            preg_match('/\d+/', $event, $id);
            return $id[0];
        }, $matches[0]);
        // da qui in poi $actual conterrà la lista degli id degli eventi
        // che compaiono nella pagina (in base all'ordine in cui compaiono)

        $expected = Event::query()   // cerca gli eventi
        ->where('starting_time', '>=', date(now()))  // tra quelli che devono ancora iniziare
        ->orderBy('starting_time')      // ordinati in base alla data di inizio
        ->get();

        $expected = $expected->filter(function (Event $event) {  //filtra, per ogni evento...
            return $event->getDistanceToMe() <= 25;   // a una distanza non superiore di 25km
        })->values()    // solo i valori
        ->pluck('id') // select sull'ID
        ->splice(12); // solo i primi 12

        $this->assertEquals($expected->toArray(), $actual);
    }
}



