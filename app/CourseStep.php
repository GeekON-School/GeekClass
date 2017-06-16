<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseStep extends Model
{
    protected $table = 'course_steps';

    protected $fillable = [
        'name', 'description', 'image', 'activation_date'
    ];

    protected $dates = [
        'activation_date'
    ];

    public function course()
    {
        return $this->belongsTo('App\Course', 'course_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany('App\Question', 'course_id', 'id');
    }

    public static function createStep($course, $data)
    {
        $step = new CourseStep();
        $step->name = $data['name'];
        $step->description = $data['description'];
        $step->notes = $data['notes'];
        $step->theory = $data['theory'];
        $step->course_id = $course->id;
        $step->save();
        return $step;
    }
    public static function editStep($step, $data)
    {
        $step->name = $data['name'];
        $step->description = $data['description'];
        $step->notes = $data['notes'];
        $step->theory = $data['theory'];
        $step->save();
        return $step;
    }
}
