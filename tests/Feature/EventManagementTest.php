<?php

namespace Tests\Feature;

use App\Http\Controllers\EventController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventManagementTest extends TestCase
{
    public function test_a_organizer_can_see_the_create_event_form()
    {
        $user = User::factory()->create();
        $request = $this->get('/event/create');
        //$re
    }

    public function test_a_normal_user_cannot_see_the_create_event_form()
    {
        $this->assertTrue(false);
    }

    public function test_a_user_can_delete_a_own_event()
    {
        $this->assertTrue(false);
    }

    public function test_a_user_cannot_delete_a_event_of_someone_else()
    {
        $this->assertTrue(false);
    }

    public function test_a_user_can_modify_a_own_event()
    {
        $this->assertTrue(false);
    }

    public function test_a_user_cannot_modify_a_event_of_someone_else()
    {
        $this->assertTrue(false);
    }
}
