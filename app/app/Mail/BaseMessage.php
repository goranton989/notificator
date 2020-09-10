<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BaseMessage extends Mailable
{
    use Queueable, SerializesModels;

    protected Message $message;

    /**
     * Create a new message instance.
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.message.base')
                    ->with([
                        'text' => 'test',
                    ]);
    }
}
