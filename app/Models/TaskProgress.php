<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskProgress extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id';

    const NOT_PINNED_ON_DASHBOARD = 0;
    const PINNED_ON_DASHBOARD = 1;
    const PROGRESS_INITIAL = 0;

    protected $guarded = [];
}
