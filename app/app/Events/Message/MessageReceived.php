<?php

namespace App\Events\Message;

use App\Resources\MessageResource;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public MessageResource $message;

    /**
     * Create a new event instance.
     *
     * @param MessageResource $message
     */
    public function __construct(MessageResource $message)
    {
        $this->message = $message;
    }
}
