<?php

namespace App\Listeners;

use App\Events\MessageSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewMessageMail;

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
