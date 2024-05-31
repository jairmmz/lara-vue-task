<?php

namespace App\Listeners;

use App\Events\CreateProjectEvent;
use App\Models\TaskProgress;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateTaskProgressListener
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
    public function handle(CreateProjectEvent $event): void
    {
        TaskProgress::create([
            'project_id' => $event->project->id,
            'pinned_on_dashboard' => TaskProgress::NOT_PINNED_ON_DASHBOARD,
            'progress' => TaskProgress::PROGRESS_INITIAL,
        ]);
    }
}
