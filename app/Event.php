<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'Events';

    public function users()
    {
        return $this->belongsToMany('App\User', 'tasks_users');
    }
}
