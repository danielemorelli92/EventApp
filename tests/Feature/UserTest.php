<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_user_profile_page_can_be_rendered()
    {
        $user = User::factory()->create();

        $response = $this->get('/user-profile/' . $user->id); // richiesta get da parte di guest

        $response->assertStatus(200);

        $response = $this->actingAs(User::factory()->create())->get('/user-profile/' . $user->id); //richiesta get da utente autenticato

        $response->assertStatus(200);
    }

    public function test_a_user_can_see_created_events_in_another_user_profile()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'author_id' => $user
        ]);

        $response = $this->get('/user-profile/' . $user->id);
        $response->assertSee($event->title);
    }

    public function test_a_user_sees_registered_events_in_another_user_profile()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'title' => 'evento a cui user è registrato',
            'starting_time' => date(now()->addDay()),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $event->registeredUsers()->attach(Auth::user());
        //$event->registeredUsers()->attach($user);

        $response = $this->get('/user-profile/' . $user->id);
        $response->assertSee($event->title);
    }
}
