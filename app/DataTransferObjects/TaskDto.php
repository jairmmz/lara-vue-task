<?php

namespace App\DataTransferObjects;

use App\Http\Requests\TaskStoreRequest;

class TaskDto
{
    public function __construct(
        public readonly string $project_id,
        public readonly string $name,
        public readonly array $member_id
    ) { }

    public static function requestStore(TaskStoreRequest $request): TaskDto
    {
        return new TaskDto(
            name: $request->validated('name'),
            project_id: $request->validated('project_id'),
            member_id: $request->validated('member_id')
        );
    }
}
