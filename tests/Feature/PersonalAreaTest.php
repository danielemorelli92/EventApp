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

        $event->users()->attach(Auth::user());

        $response = $this->get('/dashboard');
        $response->assertSee($event->title);
        $response->assertDontSee($event2->title);
    }

    // Un utente deve poter selezionare le proprie categorie di interesse dall’area personale.
    public function test_a_user_can_select_his_interests_from_his_page()
    {
        $user = User::factory()->hasTags(2)->create();
        Tag::factory(2)->create();
        $tag = Tag::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        Auth::user()->tags()->attach($tag);

        $this->assertTrue($user->tags->contains($tag), "La selezione del Tag è fallita");
    }

    // Un utente deve poter visualizzare nella propria area personale gli eventi suggeriti in base alle
    // categorie selezionate precedentemente nella propria area personale.
    public function test_a_user_can_view_suggested_events()
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->create();
        $event_interesting = Event::factory()->create([
            'title' => 'interessante',
            'starting_time' => date(now()->addWeek())
        ]); // da mostrare
        $event_not_interesting = Event::factory()->create([
            'title' => 'non mostrare',
            'starting_time' => date(now()->addWeek())
        ]); // da non mostrare
        $event_registered_already = Event::factory()->create([
            'title' => 'gia registrato',
            'starting_time' => date(now()->addWeek())
        ]); // da non mostrare
        $passed_event = Event::factory()->create([ // evento con interessi associati ma già passato
            'starting_time' => date(now()->setYear(2019))
        ]); // da non mostrare

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        Auth::user()->tags()->attach($tag);
        $event_interesting->tags()->attach($tag);
        $event_registered_already->tags()->attach($tag);
        $passed_event->tags()->attach($tag);
        $event_registered_already->users()->attach(Auth::user());

        $html_page = $this->get('/dashboard')
            ->content();

        // /<section name='suggested_events'.+?<\/section>/gms
        preg_match('/<section id="suggested_events"[\s\S]+?<\/section>/', $html_page, $matched);

        if (count($matched) > 0)
            $matched = $matched[0];
        else
            $matched = '';

        $this->assertStringContainsString($event_interesting->title, $matched, "non viene mostrato l'evento suggerito");
        $this->assertStringNotContainsString($event_not_interesting->title, $matched, "viene mostrato un evento non suggerito");
        $this->assertStringNotContainsString($event_registered_already->title, $matched, "viene mostrato un evento a cui sono registrato");
        $this->assertStringNotContainsString($passed_event->title, $matched, "viene mostrato un evento già passato");
    }

    public function test_a_user_can_view_his_events_history()
    {
        $this->assertTrue(false);
    }
}
