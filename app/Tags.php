<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $table = 'Tags';

    public function events()
    {
        return $this->belongsToMany('App\Event', 'EventTags');
    }
}