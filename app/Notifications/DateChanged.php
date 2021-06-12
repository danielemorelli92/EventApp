<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class DateChanged extends Notification
{
    use Queueable;

    protected $event;
    protected $old_date;
    protected $changed;

    public function __construct(Event $event, string $old_date)
    {
        $this->event = $event;
        $this->old_date = new Carbon($old_date);
        if ($this->old_date->isSameDay(new Carbon($this->event->starting_time))) {
            $this->changed = 'time';
        } else {
            $this->changed = 'date';
        }
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'event_id' => $this->event->id,
            'old_date' => $this->old_date,
            'changed' => $this->changed
        ];
    }
}
