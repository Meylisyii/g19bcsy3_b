<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GoogleSigninAlertNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private ?string $ipAddress;
    private ?string $userAgent;

    public function __construct(?string $ipAddress = null, ?string $userAgent = null)
    {
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('New Sign-in with Google')
            ->line('We noticed a sign-in to your account using Google.')
            ->line('Date & Time: ' . now()->toDayDateTimeString());

        if ($this->ipAddress) {
            $mail->line('IP Address: ' . $this->ipAddress);
        }

        if ($this->userAgent) {
            $mail->line('Device/Browser: ' . $this->userAgent);
        }

        $mail->line('If this was you, no further action is required.')
            ->line('If you did not sign in, please secure your account immediately.');

        return $mail;
    }
}