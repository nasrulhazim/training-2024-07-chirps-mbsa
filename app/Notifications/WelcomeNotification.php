<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
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
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->markdown(
                'notifications.welcome',
                $this->toData($notifiable)
            );
    }

    public function toSms(object $notifiable)
    {
        // implement sms sending
    }

    public function toTelegram(object $notifiable)
    {
        // implement telegram sending
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->toData($notifiable);;
    }

    private function toData(object $notifiable): array
    {
        return [
            'message' => 'Welcome to our application.',
            'url' => route('login'),
        ];
    }
}
