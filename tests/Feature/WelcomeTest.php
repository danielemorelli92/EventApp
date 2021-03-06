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
        $response = $this->get('/welcome'); // richiesta get da parte di guest

        $response->assertStatus(200);
    }

    public function test_the_welcome_page_is_rendered_correctly()
    {
        Event::factory(470)->create();
        Event::factory(30)->hasOffer()->create();

        $html_content = $this->get('/welcome')->content();
        preg_match_all('/href="\/event\/\d+"/', $html_content, $matches);
        $actual = array_map(function ($event) {
            preg_match('/\d+/', $event, $id);
            return $id[0];
        }, $matches[0]);

        // da qui in poi $actual conterrĂ  la lista degli id degli eventi
        // che compaiono nella pagina (in base all'ordine in cui compaiono)

        $futureEvents = Event::query()   // cerca gli eventi
        ->where('starting_time', '>=', date(now()))  // tra quelli che devono ancora iniziare
        ->orderBy('starting_time')      // ordinati in base alla data di inizio
        ->get();

        $expected = $futureEvents->filter(function (Event $event) {  //filtra, per ogni evento...
            return $event->getDistanceToMe() <= 25 && $event->isInPromo();   // a una distanza non superiore di 25km, in promo
        })->union($futureEvents->filter(function (Event $event) { // a cui aggiunge in fondo (push)
            return $event->getDistanceToMe() <= 25 && $event->isNotInPromo(); // a una distanza non superiore di 25km, non in promo
        }))->union($futureEvents->filter(function (Event $event) {
            return $event->getDistanceToMe() > 25 && $event->getDistanceToMe() <= 100 && $event->isInPromo(); //tra i 25 e i 100km, in promo
        }))->union($futureEvents->filter(function (Event $event) {
            return $event->getDistanceToMe() > 25 && $event->getDistanceToMe() <= 100 && $event->isNotInPromo(); //tra i 25 e i 100km, in promo
        }))->union($futureEvents->filter(function (Event $event) {
            return $event->getDistanceToMe() > 100; //oltre i 100km
        }))->values() // solo i valori
        ->pluck('id');

        $expected->splice(30);


        $this->assertEquals($expected->toArray(), $actual, 'gli elementi non vengono visualizzati oppure non nel giusto ordine');
    }
}



