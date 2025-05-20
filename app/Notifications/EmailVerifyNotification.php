<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerifyNotification extends Notification
{
    use Queueable;

    public function __construct(public string $otp) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your OTP Code')
            ->view('emails.emailVerification', [
                'otp' => $this->otp,
                'user' => $notifiable,
            ]);
    }
}
