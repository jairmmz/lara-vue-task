<?php

namespace App\DataTransferObjects;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;

class ProjectDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $start_date,
        public readonly string $end_date
    ) { }

    public static function requestStore(ProjectStoreRequest $request): ProjectDto
    {
        return new ProjectDto(
            name: $request->validated('name'),
            start_date: $request->validated('start_date'),
            end_date: $request->validated('end_date')
        );
    }

    public static function requestUpdate(ProjectUpdateRequest $request): ProjectDto
    {
        return new ProjectDto(
            name: $request->validated('name'),
            start_date: $request->validated('start_date'),
            end_date: $request->validated('end_date')
        );
    }
}
