<?php

namespace Tests\Feature;

use App\Models\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use PHPUnit\TextUI\XmlConfiguration\PHPUnit;
use Tests\TestCase;

class RequestsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_request_form_can_be_rendered()
    {
        $user = User::factory()->create();

        $request = $this->actingAs(User::find($user->id))->get('/request');

        $request->assertOk();
    }

    public function test_a_user_can_submit_a_request()
    {
        $user = User::factory()->create();

        $data = [
            'nome' => 'Nome',
            'cognome' => 'Cognome',
            'data_nascita' => '1992-09-19',
            'codice_documento' => 'AE0129212',
            'tipo_documento' => 'identity card'
        ];

        $request = $this->actingAs(User::find($user->id))->post('/request', $data);

        $actual = Request::all()
            ->where('codice_documento', 'like', $data['codice_documento'])
            ->where('tipo_documento', 'like', $data['tipo_documento']);

        $this->assertCount(1, $actual);
    }

    public function test_a_user_cannot_see_request_button_if_already_done()
    {
        $user = User::factory()->create();

        $expected = Request::make([
            'nome' => 'Nome',
            'cognome' => 'Cognome',
            'data_nascita' => '1992-09-19',
            'codice_documento' => $this->faker->bothify('??########'),
            'tipo_documento' => $this->faker->randomElement(['driving license', 'identity card', 'passport'])
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->post('/request', $expected->toArray());

        $response = $this->get('/dashboard');
        $response->assertSee('Abilitazione in approvazione');
        $response->assertDontSee('Richiedi abilitazione');
    }

    public function test_a_user_cannot_access_request_form_if_already_requested()
    {
        $user = User::factory()->create();

        $expected = Request::make([
            'nome' => 'Nome',
            'cognome' => 'Cognome',
            'data_nascita' => '1992-09-19',
            'codice_documento' => $this->faker->bothify('??########'),
            'tipo_documento' => $this->faker->randomElement(['driving license', 'identity card', 'passport'])
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->post('/request', $expected->toArray());

        $response = $this->get('/request');
        $response->assertRedirect('/dashboard');

    }

/*    public function test_a_user()
    {

    }*/
}
