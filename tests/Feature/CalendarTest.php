<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_s_calendar_can_be_rendered()
    {
        $request = $this->actingAs(User::factory()->create())->get('/calendar');

        $request->assertOk();
    }

    public function test_a_registered_event_can_be_rendered_on_the_calendar()
    {
        $event1 = Event::factory()->create([
            'starting_time' => '2021-06-15'
        ]);
        $event2 = Event::factory()->create([
            'starting_time' => '2021-07-15'
        ]);
        $user = User::factory()->create();

        $event1->registeredUsers()->attach($user->id);
        $event2->registeredUsers()->attach($user->id);


        $response = $this->actingAs($user)->get('/calendar/2021-06');

        $response->assertSee($event1->title);
        $response->assertDontSee($event2->title);
    }
}
