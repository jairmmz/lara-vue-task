<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\TaskMember;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateTaskMemberJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $member_id,
        public Task $task
    ) { }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->member_id as $member_id) {
            TaskMember::create([
                'project_id' => $this->task->project_id,
                'task_id' => $this->task->id,
                'member_id' => $member_id,
            ]);
        }
    }
}
