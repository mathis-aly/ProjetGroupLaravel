<?php

namespace App\Listeners;

use App\Events\MessageSent;
use App\Mail\NewMessageMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendNewMessageNotification
{
    use InteractsWithQueue;

    // Le type-hint suffit : Laravel découvre seul que ce listener écoute MessageSent
    public function handle(MessageSent $event): void
    {
        $message = $event->message;
        Mail::to($message->listing->user->email)
            ->send(new NewMessageMail($message));

    }
}
