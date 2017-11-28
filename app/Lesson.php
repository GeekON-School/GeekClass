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
        return $this->hasMany('App\CourseStep', 'lesson_id', 'id')->with('tasks')->orderBy('sort_index')->orderBy('id');
    }

    public function percent(User $student)
    {
        $points = $this->points($student);
        $max_points = $this->max_points($student);
        if ($max_points == 0) return 100;
        return $points * 100 / $max_points;

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
