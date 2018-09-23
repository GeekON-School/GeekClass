<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'text', 'step_id', 'deadline', 'name', 'max_mark', 'is_star', 'only_class', 'only_remote', 'sort_index', 'is_quiz', 'is_code'
    ];

    protected $dates = [
        'deadline'
    ];

    public function step()
    {
        return $this->belongsTo('App\ProgramStep', 'step_id', 'id');
    }

    public function solutions()
    {
        return $this->hasMany('App\Solution', 'task_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany('App\Question', 'task_id', 'id');
    }

    public function consequences()
    {
        return $this->belongsToMany('App\CoreNode', 'core_consequences', "task_id", "node_id");
    }

    public function isDone($user_id)
    {
        return $this->solutions()->where('user_id', $user_id)->where('mark', '>', 1)->count() !=0;
    }

    public function isFullDone($user_id)
    {
        return $this->solutions()->where('user_id', $user_id)->where('mark', '=', $this->max_mark)->count() !=0;
    }



}
