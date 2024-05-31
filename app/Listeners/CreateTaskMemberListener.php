<?php

namespace App\Listeners;

use App\Events\CreateTaskEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateTaskMemberListener
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
    public function handle(CreateTaskEvent $event): void
    {
        //
    }
}
