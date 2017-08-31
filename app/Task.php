<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'text', 'step_id', 'deadline', 'name'
    ];

    protected $dates = [
        'deadline'
    ];

    public function step()
    {
        return $this->belongsTo('App\CourseStep', 'step_id', 'id');
    }


}
