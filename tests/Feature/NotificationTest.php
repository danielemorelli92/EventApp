<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use App\Notifications\CityChanged;
use App\Notifications\DateChanged;
use App\Notifications\DescriptionChanged;
use App\Notifications\EventCanceled;
use App\Notifications\ReplyToMe;
use App\Notifications\TitleChanged;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;


    public function test_a_user_registered_for_an_event_receives_a_notification_if_the_title_is_changed()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        $event->registeredUsers()->attach($user);
        $admin = User::factory()->create();
        DB::table('users')->where('id', $admin->id)->update(['type' => 'admin']);

        $this->actingAs($admin)->put('/events/' . $event->id, [
            'title' => 'new title'
        ]);

        $notifica = $user->notifications->first();

        self::assertNotNull($notifica, 'l\'utente non riceve la notifica');
        self::assertEquals(TitleChanged::class, $notifica->type, 'l\'utente non riceve la giusta notifica');
        self::assertCount(1, $user->notifications, 'l\'utente riceve più notifiche di quelle attese');
    }

    public function test_a_user_registered_for_an_event_receives_a_notification_if_the_description_is_changed()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        $event->registeredUsers()->attach($user);
        $admin = User::factory()->create();
        DB::table('users')->where('id', $admin->id)->update(['type' => 'admin']);

        $this->actingAs($admin)->put('/events/' . $event->id, [
            'description' => 'new description'
        ]);

        $notifica = $user->notifications->first();

        self::assertNotNull($notifica, 'l\'utente non riceve la notifica');
        self::assertEquals(DescriptionChanged::class, $notifica->type, 'l\'utente non riceve la giusta notifica');
        self::assertCount(1, $user->notifications, 'l\'utente riceve più notifiche di quelle attese');
    }

    public function test_a_user_registered_for_an_event_receives_a_notification_if_the_date_is_changed()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        $event->registeredUsers()->attach($user);
        $admin = User::factory()->create();
        DB::table('users')->where('id', $admin->id)->update(['type' => 'admin']);

        $this->actingAs($admin)->put('/events/' . $event->id, [
            'starting_time' => date(now()->addDays(3)->setHour(3))
        ]);

        $notifica = $user->notifications->first();

        self::assertNotNull($notifica, 'l\'utente non riceve la notifica');
        self::assertEquals(DateChanged::class, $notifica->type, 'l\'utente non riceve la giusta notifica');
        self::assertCount(1, $user->notifications, 'l\'utente riceve più notifiche di quelle attese');
    }

    public function test_a_user_registered_for_an_event_receives_a_notification_if_the_event_is_deleted()
    {
        $event = Event::factory()->create([
            'starting_time' => date(now()->addDays(4))
        ]);
        $user = User::factory()->create();
        $event->registeredUsers()->attach($user);
        $admin = User::factory()->create();
        DB::table('users')->where('id', $admin->id)->update(['type' => 'admin']);

        $this->actingAs($admin)->delete('/events/' . $event->id);

        $notifica = $user->notifications->first();

        self::assertNotNull($notifica, 'l\'utente non riceve la notifica');
        self::assertEquals(EventCanceled::class, $notifica->type, 'l\'utente non riceve la giusta notifica');
        self::assertCount(1, $user->notifications, 'l\'utente riceve più notifiche di quelle attese');
    }

    public function test_a_user_receives_notifications_for_replies_to_their_comments()
    {
        $event = Event::factory()->hasComments(1)->create();
        $comment = $event->comments->first();
        $commentator = $comment->author;
        $responding_user = User::factory()->create();

        $this->actingAs($responding_user)->post('/comment/' . $event->id . '/' . $comment->id, [
            'content' => 'A new reply!'
        ]);

        $notifica = $commentator->notifications->first();

        self::assertNotNull($notifica, 'l\'utente non riceve la notifica');
        self::assertEquals(ReplyToMe::class, $notifica->type, 'l\'utente non riceve la giusta notifica');
        self::assertCount(1, $commentator->notifications, 'l\'utente riceve più notifiche di quelle attese');
    }

    public function test_a_user_registered_for_an_event_receives_a_notification_if_the_city_is_changed()
  {
      $event = Event::factory()->create();
      $user = User::factory()->create();
      $event->registeredUsers()->attach($user);
      $admin = User::factory()->create();
      DB::table('users')->where('id', $admin->id)->update(['type' => 'admin']);

      $this->actingAs($admin)->put('/events/' . $event->id, [
          'city' => 'new city'
      ]);

      $notifica = $user->notifications->first();

      self::assertNotNull($notifica, 'l\'utente non riceve la notifica');
      self::assertEquals(CityChanged::class, $notifica->type, 'l\'utente non riceve la giusta notifica');
      self::assertCount(1, $user->notifications, 'l\'utente riceve più notifiche di quelle attese');
  }
}
