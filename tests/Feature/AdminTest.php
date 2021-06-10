<?php

namespace Tests\Feature;

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

        self::assertTrue(false);

    }

    public function test_an_admin_does_not_see_the_button_to_remove_the_permissions_on_the_page_of_a_normal_user()
    {
        self::assertTrue(false);
    }

    public function test_an_admin_can_remove_the_permissions_of_an_organizer()
    {
        self::assertTrue(false);
    }
}
