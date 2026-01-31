<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskNotification extends Notification
{
    use Queueable;

    public $message;
    public $link;
    public $type; // e.g., 'task', 'note', 'subtask'

    public function __construct($message, $link, $type = 'task')
    {
        $this->message = $message;
        $this->link = $link;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database']; // سنخزنها في قاعدة البيانات
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'link' => $this->link,
            'type' => $this->type,
        ];
    }
}