<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CityChanged extends Notification
{
    use Queueable;

    protected $event;
    protected $old_city;

    public function __construct(Event $event, string $old_city)
    {
        $this->event = $event;
        $this->old_city = $old_city;
    }


    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'event_id' => $this->event->id,
            'old_city' => $this->old_city
        ];
    }
}
