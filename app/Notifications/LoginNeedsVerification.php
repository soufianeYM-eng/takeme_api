<?php

namespace App\Notifications;

use NotificationChannels\Telegram\TelegramMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;

class LoginNeedsVerification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        $loginCode = rand(111111, 999999);

        $notifiable->update([
            'login_code' => $loginCode,
        ]);

        return TelegramMessage::create()->content("Hello Your login code is {$loginCode}, don't share this with anyone!");
    }
}
