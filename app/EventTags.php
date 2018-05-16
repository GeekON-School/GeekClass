<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventTags extends Model
{
    protected $table = 'Tags';

    public function events()
    {
        return $this->belongsToMany('App\Event', 'EventTags');
    }
}