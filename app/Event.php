<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    public function userOrgs()
    {
        return $this->belongsToMany('App\User', 'event_orgs');
    }

    public function userPartis()
    {
        return $this->belongsToMany('App\User', 'event_partis');
    }

    public function userLikes()
    {
        return $this->belongsToMany('App\User', 'event_likes');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tags', 'event_tags', "event_id", "tag_id");
    }

}
