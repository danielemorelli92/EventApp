<?php

namespace App\Notifications;

use App\Models\Event;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReplyToMe extends Notification
{
    use Queueable;

    protected $event;
    protected $reply_user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Event $event, User $user)
    {
        $this->event = $event;
        $this->reply_user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'event_id' => $this->event->id,
            'user_id' => $this->reply_user->id
        ];
    }
}
