<?php

namespace App\Listeners\Message;

use App\Events\Message\MessageReceived;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailNotification implements ShouldQueue
{
    public string $connection = 'redis';

    /**
     * Handle the event.
     *
     * @param  MessageReceived  $event
     * @return void
     */
    public function handle(MessageReceived $event)
    {
        $event->message->setRecipients(config('notificator.recipients'))->sendEmail();
    }
}
