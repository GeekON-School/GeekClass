<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'Events';

    public function userOrgs()
    {
        return $this->belongsToMany('App\User', 'EventOrgs');
    }

    public function userPartis()
    {
        return $this->belongsToMany('App\User', 'EventPartis');
    }

    public function userLikes()
    {
        return $this->belongsToMany('App\User', 'EventLikes');
    }

    public function tags()
    {
        return $this->belongsToMany('App\EventTags', 'EventTags');
    }
}
