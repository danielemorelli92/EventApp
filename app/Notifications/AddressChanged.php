<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddressChanged extends Notification
{
    use Queueable;

    protected $event;
    protected $old_address;

    public function __construct(Event $event, string $old_address)
    {
        $this->event = $event;
        $this->old_address = $old_address;
    }


    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'event_id' => $this->event->id,
            'old_address' => $this->old_address
        ];
    }
}
