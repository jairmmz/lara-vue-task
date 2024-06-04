<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskMember extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }
}
