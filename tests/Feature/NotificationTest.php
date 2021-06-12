<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $event;
    protected $user;
    protected $admin;

    public function test_a_user_registered_for_an_event_receives_a_notification_if_the_title_is_changed()
    {
        $this->actingAs($this->admin)->put('/events/' . $this->event->id, [
            'title' => 'new title'
        ]);

        $notifica = $this->user->notifications->first();

        self::assertNotNull($notifica, 'non è stata inviata alcuna notifica all\'utente');
        self::assertEquals('App\Notifications\TitleChanged', $notifica->type, 'la notifica viene inviata ma non è del tipo giusto');
        self::assertCount(1, $this->user->notifications, 'vengono inviate notifiche non previste');
    }

    protected function setUp(): void
    {
        $this->event = Event::factory()->create();
        $this->user = User::factory()->create();
        $this->event->registeredUsers()->attach($this->user);
        $this->admin = User::factory()->create();
        $this->admin->update(['type' => 'admin']);
    }
}
