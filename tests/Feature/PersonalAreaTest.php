<?php

namespace Tests\Feature;

use App\Models\{ExternalRegistration, Tag, User, Event};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PersonalAreaTest extends TestCase
{
    use RefreshDatabase;

    public function test_personal_area_can_be_rendered()
    {
        $response = $this->get('/dashboard'); // richiesta get da parte di guest
        $response->assertRedirect('/login');
        $response = $this->actingAs(User::factory()->create())->get('/dashboard'); //richiesta get da utente autenticato
        $response->assertStatus(200);
    }

    public function test_registered_user_sees_events_where_is_registered()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'title' => 'evento a cui sei registrato',
            'starting_time' => date(now()->addDay())
        ]);
        $event2 = Event::factory()->create([
            'title' => 'non deve essere visto',
            'starting_time' => date(now()->addDay())
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
        $html_page = $this->get('/dashboard')->content();

        // /<section name='registered_events'.+?<\/section>/gms
        preg_match('/<section id="registered_events"[\s\S]+?<\/section>/', $html_page, $matched);
        if ($this->count($matched) > 0)
            $matched = $matched[0];
        else
            $matched = '';
        $this->assertStringContainsString($event->title, $matched);
        $this->assertStringNotContainsString($event2->title, $matched);
    }

    // Un utente deve poter visualizzare le proprie categorie di interesse scelte dall’area personale.
    public function test_a_user_can_view_his_selected_interests_on_his_page()
    {
        $user = User::factory()->create();
        $request = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $html_page = $request->content();
        preg_match_all('/\<input type="checkbox".+?value="\d+" checked\>/', $html_page, $matches);
        $matches = $matches[0];

        $actual = array_map(function ($elem) {
            preg_match('/\d+/', $elem, $ids);
            return $ids[0];
        }, $matches);  // actual adesso contiene la lista di id delle checkbox selezionate

        $expected = $user->tags->values()->pluck('id')->toArray();
        foreach ($expected as $elem) {
            $this->assertContains($elem, $actual);
        }
        foreach ($actual as $elem) {
            $this->assertContains($elem, $expected);
        }
    }

    // Un utente deve poter selezionare le proprie categorie di interesse dall’area personale.
    public function test_a_user_can_select_his_interests_from_his_page()
    {
        $user = User::factory()->hasTags(2)->create();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $tag = Tag::factory()->create();
        $this->post('attach_tag_to_user/' . $tag->id);
        $this->assertTrue($user->tags->contains($tag),"La selezione del Tag è fallita");
    }

    // Un utente deve poter visualizzare nella propria area personale gli eventi suggeriti in base alle
    // categorie selezionate precedentemente nella propria area personale.
    public function test_a_user_can_view_suggested_events()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $tag = Tag::factory()->create();

        $event_interesting = Event::factory()->create([
            'title' => 'interessante'
        ]); // da mostrare
        $event_not_interesting = Event::factory()->create([
            'title' => 'non mostrare'
        ]); // da non mostrare
        $event_registered_already = Event::factory()->create([
            'title' => 'gia registrato'
        ]); // da non mostrare
        $passed_event = Event::factory()->create([ // evento con interessi associati ma già passato
            'starting_time' => date(now()->setYear(2019))
        ]); // da non mostrare

        $this->post('attach_tag_to_user/' . $tag->id);
        $this->post('attach_tag_to_event/' . $tag->id . '/' . $event_interesting->id);
        $this->post('attach_tag_to_event/' . $tag->id . '/' . $event_registered_already->id);
        $this->post('attach_tag_to_event/' . $tag->id . '/' . $passed_event->id);
        $this->post('/registration', [
            'event' => $event_registered_already->id
        ]);

        $html_page = $this->get('/dashboard')
            ->content();

        // /<section name='suggested_events'.+?<\/section>/gms
        preg_match('/<section id="suggested_events"[\s\S]+?<\/section>/', $html_page, $matched);

        if ($this->count($matched) > 0)
            $matched = $matched[0];
        else
            $matched = '';

        $this->assertStringContainsString($event_interesting->title, $matched, "non viene mostrato l'evento suggerito");
        $this->assertStringNotContainsString($event_not_interesting->title, $matched, "viene mostrato un evento non suggerito");
        $this->assertStringNotContainsString($event_registered_already->title, $matched, "viene mostrato un evento a cui sono registrato");
        $this->assertStringNotContainsString($passed_event->title, $matched, "viene mostrato un evento già passato");
    }
}
