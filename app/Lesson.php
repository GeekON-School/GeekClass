<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table = 'lessons';

    protected $fillable = [
        'name', 'description', 'image', 'start_date'
    ];

    protected $dates = [
        'start_date'
    ];

    protected $results_cache = array();

    public function course()
    {
        return $this->belongsTo('App\Course', 'course_id', 'id');
    }

    public function steps()
    {
        return $this->hasMany('App\CourseStep', 'lesson_id', 'id')->orderBy('sort_index')->orderBy('id');
    }

    public function percent(User $student)
    {
        $sum = 0;
        foreach ($this->steps as $step)
            $sum += $step->percent($student);
        return $sum / count($this->steps());
    }

    public function points(User $student)
    {
        $sum = 0;
        foreach ($this->steps as $step)
            $sum += $step->points($student);
        return $sum;
    }

    public function max_points(User $student)
    {
        $sum = 0;
        foreach ($this->steps as $step)
            $sum += $step->max_points($student);
        return $sum;
    }

}
