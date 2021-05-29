<?php

namespace Tests\Feature;

use App\Models\Request;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RequestsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_request_form_can_be_rendered()
    {
        $request = $this->get('/request');

        $request->assertOk();
    }

    public function test_a_user_can_submit_a_request()
    {
        $user = User::factory()->create();
        $expected = Request::make([
            'nome' => 'Nome',
            'cognome' => 'Cognome',
            'data_nascita' => '1992-09-19',
            'codice_documento' => $this->faker->bothify('##??????????'),
            'tipo_documento' => $this->faker->randomElement(['driving license', 'identity card', 'passport'])
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->post('/request', $expected);

        $actual = Request::find($expected->id);

        $this->assertEquals($expected, $actual, 'la richiesta non è stata inviata correttamente');
    }


}
