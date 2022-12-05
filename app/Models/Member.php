<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'id',
        'name',
        'last_name',
        'team_id',
        'task_id',
        'helper_id',
        'is_winner',
    ];


    public function team()
    {
        return $this->hasOne(Team::class);
    }

    public function task()
    {
        return $this->hasOne(Task::class);
    }

    public function helper()
    {
        return $this->hasOne(Member::class);
    }

    public function getFullAttribute(): string
    {
        return $this->attributes['last_name'] . ' ' . $this->attributes['name'];
    }
}
