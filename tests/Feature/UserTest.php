<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
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
            'title' => 'evento a cui user ha partecipato',
            'starting_time' => date(now()->subWeek())
        ]);

        $event->registeredUsers()->attach($user);

        $response = $this->get('/user-profile/' . $user->id);
        $response->assertSee($event->title);
    }

    public function test_a_user_can_edit_its_info()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $request = $this->actingAs($user)->get('/user/edit');

        $request->assertOk();  // può accedere alla pagina di modifica dati personali

        $request = $this->actingAs($user)->put('/user', [
            'name' => 'new name',
            'email' => 'newemail@gmail.com',
            'numero_telefono' => '0123456789',
            'sito_web' => 'www.newsite.com',
            'birthday' => date('1992-09-09')
        ]);

        $user->refresh();

        $this->assertEquals('new name', $user->name, 'il nome non è stato modificato');
        $this->assertEquals('newemail@gmail.com', $user->email, 'l\'email non è stata modificata');
        $this->assertEquals('0123456789', $user->numero_telefono, 'il numero di telefono non è stato modificato');
        $this->assertEquals('www.newsite.com', $user->sito_web, 'il sitoweb non è stato modificato');
        $this->assertEquals('1992-09-09', $user->birthday, 'l\'anno di nascita non è stato modificato');
    }
}
