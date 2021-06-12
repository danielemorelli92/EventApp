<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use function Sodium\add;

class EventCanceled extends Notification
{
    use Queueable;

    protected $title;
    protected $start;
    protected $address;

    public function __construct(string $title, string $start, string $address)
    {
        $this->title = $title;
        $this->address = $address;
        $this->start = $start;
    }


    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'address' => $this->address,
            'starting_time' => $this->start
        ];
    }
}
