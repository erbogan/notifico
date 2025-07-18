<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public $token;
    public $email;
    public function __construct($token,$email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $this->email,
        ], false));

        return (new MailMessage)
            ->subject('Passwort zurücksetzen')
            ->greeting('Hallo!')
            ->line('Wir haben eine Anfrage erhalten, das Passwort für dein Konto zurückzusetzen.')
            ->action('Passwort zurücksetzen', $url)
            ->line('Dieser Link ist 60 Minuten lang gültig.')
            ->line('Falls du kein neues Passwort angefordert hast, ignoriere bitte diese E-Mail.')
            ->salutation('Viele Grüße, dein Mahltime Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
