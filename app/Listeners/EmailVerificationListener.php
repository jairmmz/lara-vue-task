<?php

namespace App\Listeners;

use App\Events\NewUserEvent;
use App\Mail\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailVerificationListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewUserEvent $event): void
    {
        Mail::to($event->user->email)->send(new SendMail($event->user));
        Log::info('Correo enviado a: ' . $event->user->email);
    }
}
