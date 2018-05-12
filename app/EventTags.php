<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventTags extends Model
{
    protected $table = 'EventsTags';

    public function events()
    {
        return $this->belongsToMany('App\Event', 'EventTags');
    }
}
