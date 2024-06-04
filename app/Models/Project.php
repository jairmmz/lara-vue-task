<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id';

    const NOT_STARTED = 0;
    const PENDING = 1;
    const COMPLETED = 2;

    protected $guarded = [];

    public static function generateSlug($name)
    {
        return Str::slug($name) . '-' . Str::random(10) . '-' . time();
    }

    public function taskProgress()
    {
        return $this->hasOne(TaskProgress::class, 'project_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id', 'id');
    }
}
