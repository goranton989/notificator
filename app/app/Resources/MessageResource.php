<?php

namespace App\Resources;

use App\Events\Message\MessageReceived;
use App\Mail\BaseMessage;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MessageResource {
    private Message $message;
    private array $recipients = [];

    public function setMessage(Message $message): MessageResource
    {
        $this->message = $message;
        return $this;
    }

    public function setRecipients(array $recipients): MessageResource
    {
        $this->recipients = $recipients;
        return $this;
    }

    public function storeMessage($payload) {
        /** @var User $user */
        $user = $payload['user'];
        /** @var Message $message */
        $message = $user->messages()
            ->create(['message' => $payload['message']]);
        return $this->setMessage($message);
    }

    public function notify() {
        MessageReceived::dispatch($this);
        return $this;
    }

    public function sendEmail() {
        \Log::debug($this->message->message);
        foreach ($this->recipients as $recipient) {
            Mail::to($recipient)
                ->send(new BaseMessage($this->message));
        }
    }
}
