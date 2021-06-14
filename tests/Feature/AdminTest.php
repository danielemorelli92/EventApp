<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Request;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Tests\TestCase;

class AdminTest extends TestCase
{
    public function test_an_admin_sees_the_button_to_remove_permissions_on_the_organizers_page()
    {
        $admin = User::factory()->create();
        DB::table('users')
            ->where('id', $admin->id)
            ->update(['type' => 'admin']);
        $organizer = User::factory()->create();
        DB::table('users')
            ->where('id', $organizer->id)
            ->update(['type' => 'organizzatore']);

        $response = $this->actingAs($admin)->get('/user-profile/' . $organizer->id);
        $response->assertSee('Rimuovi permessi');
    }

    public function test_an_admin_does_not_see_the_button_to_remove_the_permissions_on_the_page_of_a_normal_user()
    {
        $admin = User::factory()->create();
        DB::table('users')
            ->where('id', $admin->id)
            ->update(['type' => 'admin']);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->get('/user-profile/' . $user->id);
        $response->assertDontSee('Rimuovi permessi');
    }

    public function test_an_admin_can_remove_the_permissions_of_an_organizer()
    {
        $admin = User::factory()->create();
        DB::table('users')
            ->where('id', $admin->id)
            ->update(['type' => 'admin']);
        $user = User::factory()->create();
        $request = Request::create([
            'codice_documento' => 'EA029232',
            'tipo_documento' => 'driving license',
            'nome' => 'NomeUtente',
            'cognome' => 'CognomeUtente',
            'data_nascita' => '1992-09-19',
            'user_id' => $user->id
        ]);
        DB::table('users')
            ->where('id', $user->id)
            ->update(['type' => 'organizzatore']);

        $this->actingAs($admin)->delete('/permissions/' . $user->id);

        self::assertEquals('normale', $user->fresh()->type, 'non sono stati tolti i permessi all\'organizzatore');
    }

    public function test_an_admin_sees_the_button_to_delete_an_event_on_any_event_page()
    {
        $admin = User::factory()->create();
        DB::table('users')
            ->where('id', $admin->id)
            ->update(['type' => 'admin']);
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'author_id' => $user->id
        ]);

        $request = $this->actingAs($admin)->get('/event/' . $event->id);

        $request->assertSee('Cancella');
    }

    public function test_an_admin_can_delete_any_event()
    {
        $admin = User::factory()->create();
        DB::table('users')
            ->where('id', $admin->id)
            ->update(['type' => 'admin']);
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'author_id' => $user->id
        ]);
        $this->actingAs($admin)->delete('/events/' . $event->id);

        self::assertNull($event->fresh(), 'l\'evento non è stato cancellato');
    }

    public function test_an_admin_can_view_the_event_edit_page()
    {
        $admin = User::factory()->create();
        DB::table('users')
            ->where('id', $admin->id)
            ->update(['type' => 'admin']);
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'author_id' => $user->id
        ]);
        $response = $this->actingAs($admin)->get('/events/edit/' . $event->id);

        $response->assertOk();
    }

    public function test_an_admin_can_modify_user_s_event_from_event_page()
    {
        $admin = User::factory()->create();
        DB::table('users')
            ->where('id', $admin->id)
            ->update(['type' => 'admin']);
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'author_id' => $user->id
        ]);

        $response = $this->actingAs($admin)->get('/event/' . $event->id);

        $response->assertSee('Modifica');
    }

    public function test_an_admin_can_modify_a_event()
    {
        $admin = User::factory()->create();
        DB::table('users')
            ->where('id', $admin->id)
            ->update(['type' => 'admin']);
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'author_id' => $user->id
        ]);

        $this->actingAs($admin)->put('/events/' . $event->id, [
            'title' => 'new title'
        ]);

        self::assertEquals('new title', $event->fresh()->title, 'l\'evento non è stato modificato dall\'admin');
    }

    public function test_admin_can_view_admin_page()
    {
        $user = User::factory()->create(); // crea l'utente

        $user->type = 'admin'; // upgrade locale ad admin

        DB::table('users')
            ->where('email', $user->email)
            ->update(['type' => 'admin']); // upgrade sul database ad admin

        $request = $this->actingAs($user)->get('/admin_page');

        $request->assertOk();
    }

    public function test_other_users_cannot_view_admin_page()
    {
        $user1 = User::factory()->create(); // sarà utente normale
        $user2 = User::factory()->create(); // sarà organizzatore

        $user2->type = 'organizzatore'; // locale

        DB::table('users')
            ->where('email', $user2->email)
            ->update(['type' => 'organizzatore']);  // sul db

        $request1 = $this->actingAs($user1)->get('/admin_page');
        $request2 = $this->actingAs($user2)->get('/admin_page');

        $request1->assertStatus(401);
        $request2->assertStatus(401);
    }

    public function test_admin_can_see_requests_list_in_admin_page()
    {
        $admin = User::factory()->create();

        $admin->type = 'admin';

        DB::table('users')
            ->where('email', $admin->email)
            ->update(['type' => 'admin']); // upgrade sul database ad admin

        $response = $this->actingAs($admin)->get('/admin_page');

        $response->assertSee('lista_richieste');

    }

    public function test_admin_can_see_users_list_in_admin_page()
    {
        $admin = User::factory()->create();

        $admin->type = 'admin';

        DB::table('users')
            ->where('email', $admin->email)
            ->update(['type' => 'admin']); // upgrade sul database ad admin

        $response = $this->actingAs($admin)->get('/admin_page');

        $response->assertSee('lista_utenti');
    }

    public function test_admin_can_access_to_a_user_page_from_admin_page()
    {
        $admin = User::factory()->create();

        $admin->type = 'admin';

        DB::table('users')
            ->where('email', $admin->email)
            ->update(['type' => 'admin']); // upgrade sul database ad admin

        $user = User::factory()->create();

        $response = $this->actingAs($admin)->get('/admin_page');

        $response->assertSee('/user-profile/' . $user->id);
    }

    public function test_admin_can_see_accept_and_reject_buttons_in_admin_page()
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();

        $admin->type = 'admin';

        DB::table('users')
            ->where('email', $admin->email)
            ->update(['type' => 'admin']); // upgrade sul database ad admin

        Request::create([
            'codice_documento' => 'EA049232',
            'tipo_documento' => 'driving license',
            'nome' => 'NomeUtente',
            'cognome' => 'CognomeUtente',
            'data_nascita' => '1992-09-19',
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($admin)->get('/admin_page');

        $response->assertSee('Accetta');
        $response->assertSee('Rifiuta');
    }

    public function test_admin_can_accept_a_request_in_admin_page()
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();

        $admin->type = 'admin';

        DB::table('users')
            ->where('email', $admin->email)
            ->update(['type' => 'admin']); // upgrade sul database ad admin

        $request = Request::create([
            'codice_documento' => 'EA049232',
            'tipo_documento' => 'driving license',
            'nome' => 'NomeUtente',
            'cognome' => 'CognomeUtente',
            'data_nascita' => '1992-09-19',
            'user_id' => $user->id
        ]);

        $this->actingAs($admin)->post('/permissions/' . $user->id);

        self::assertEquals('organizzatore', $user->fresh()->type, 'non sono stati aggiunti i permessi all\'organizzatore');
    }

    public function test_admin_can_reject_a_request_in_admin_page()
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();

        $admin->type = 'admin';

        DB::table('users')
            ->where('email', $admin->email)
            ->update(['type' => 'admin']); // upgrade sul database ad admin

        $request = Request::create([
            'codice_documento' => 'EA049232',
            'tipo_documento' => 'driving license',
            'nome' => 'NomeUtente',
            'cognome' => 'CognomeUtente',
            'data_nascita' => '1992-09-19',
            'user_id' => $user->id
        ]);

        $this->actingAs($admin)->delete('/request/' . $request->id);

        self::assertNull($request->fresh(), 'la richiesta non è stata cancellata');
    }

}
