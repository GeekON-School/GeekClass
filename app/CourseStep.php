<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CourseStep extends Model
{
    protected $table = 'course_steps';

    protected $fillable = [
        'name', 'description', 'image', 'start_date'
    ];

    protected $dates = [
        'start_date'
    ];

    public function course()
    {
        return $this->belongsTo('App\Course', 'course_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany('App\Question', 'step_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task', 'step_id', 'id')->orderBy('id');
    }
    public function class_tasks()
    {
        return $this->hasMany('App\Task', 'step_id', 'id')->Where('only_remote', false)->orderBy('id');
    }
    public function remote_tasks()
    {
        return $this->hasMany('App\Task', 'step_id', 'id')->Where('only_class', false)->orderBy('id');
    }

    public static function createStep($course, $data)
    {
        $step = new CourseStep();
        $step->name = $data['name'];
        $step->description = $data['description'];
        $step->notes = $data['notes'];
        $step->theory = $data['theory'];
        $step->course_id = $course->id;
        $step->start_date = Carbon::createFromFormat('Y-m-d', $data['start_date']);
        $step->save();
        return $step;
    }
    public static function editStep($step, $data)
    {
        $step->name = $data['name'];
        $step->description = $data['description'];
        $step->notes = $data['notes'];
        $step->theory = $data['theory'];
        $step->start_date = Carbon::createFromFormat('Y-m-d', $data['start_date']);
        $step->save();
        return $step;
    }
}
