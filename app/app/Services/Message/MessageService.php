<?php

namespace App\Services\Message;

use App\Models\User;
use App\Resources\MessageResource;

class MessageService
{
    private MessageResource $messageResource;

    public function __construct(MessageResource $messageResource)
    {
        $this->messageResource = $messageResource;
    }

    public function userCanStore(User $user)
    {
        $attempt = $user->messageAttempt;
        $max = config('notificator.max');

        if (!$attempt) {
            $attempt = $user->messageAttempt()->create(compact('user'));
        }

        // If user did not spend attempts
        if ($attempt->number < config('notificator.attempts')) {
            $attempt->touch();
            return true;
        }

        // If delay has
        if ($attempt->lastAttemptInSeconds() > config('notificator.delay')) {
            $attempt->reset();
            return true;
        }

        // Max message count
        if ($max > 0 && $user->messages()->count() <= $max) {
            return false;
        }

        return false;
    }

    public function storeAndNotify(string $message, User $user)
    {
        $this->messageResource
            ->storeMessage(compact('message', 'user'))
            ->notify();
        return $this;
    }
}
