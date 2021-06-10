<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Request;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
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
        $this->withoutExceptionHandling();
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
}
