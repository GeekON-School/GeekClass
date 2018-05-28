<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventComments extends Model
{
    protected $table = 'EventComments';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
