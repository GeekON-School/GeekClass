<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'text', 'step_id', 'deadline', 'name', 'max_mark', 'is_star', 'only_class', 'only_remote', 'sort_index'
    ];

    protected $dates = [
        'deadline'
    ];

    public function step()
    {
        return $this->belongsTo('App\CourseStep', 'step_id', 'id');
    }

    public function solutions()
    {
        return $this->hasMany('App\Solution', 'task_id', 'id');
    }


}
