<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'project' => ProjectResource::make($this),
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
            'task_progress' => TaskProgressResource::make($this->whenLoaded('taskProgress'))
        ];
    }
}
