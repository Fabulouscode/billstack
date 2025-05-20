<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\EmailVerifyNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendVerificationEmail implements ShouldQueue
{
    use Dispatchable, Queueable;

    public $tries = 5;

    protected User $user;
    protected string $otp;

    public function __construct(User $user, string $otp)
    {
        $this->user = $user;
        $this->otp = $otp;
    }

    public function handle(): void
    {
        try {
            $this->user->notify(new EmailVerifyNotification($this->otp));
        } catch (\Throwable $e) {
            Log::error('Failed to send verification email', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
