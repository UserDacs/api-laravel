<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

class GeneralNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $title;
    protected $category;

    public function __construct($message, $title = 'Notification', $category = 'general')
    {
        $this->message = $message;
        $this->title = $title;
        $this->category = $category;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        // Real-time push to socket server
        Http::post('http://192.168.1.100:3000/notify', [
            'userId'   => $notifiable->id,
            'message'  => $this->message,
            'title'    => $this->title,
            'category' => $this->category,
        ]);

        return [
            'message'  => $this->message,
            'title'    => $this->title,
            'category' => $this->category,
        ];
    }
}
