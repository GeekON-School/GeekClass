<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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

    public function program()
    {
        return $this->belongsTo('App\Program', 'program_id', 'id');
    }

    public function steps()
    {
        return $this->hasMany('App\ProgramStep', 'lesson_id', 'id')->with('tasks')->orderBy('sort_index')->orderBy('id');
    }

    public function percent(User $student, Course $course)
    {
        $points = $this->points($student, $course);
        $max_points = $this->max_points($student, $course);
        if ($max_points == 0) return 100;
        return $points * 100 / $max_points;

    }

    public function points(User $student, Course $course)
    {
        $sum = 0;
        foreach ($this->steps as $step)
            $sum += $step->points($student, $course);
        return $sum;
    }

    public function max_points(User $student, Course $course)
    {
        $sum = 0;
        foreach ($this->steps as $step)
            $sum += $step->max_points($student, $course);
        return $sum;
    }

    public function tasks()
    {
        $tasks = new \Illuminate\Database\Eloquent\Collection;;
        foreach ($this->steps as $step)
        {
            $tasks = $tasks->merge($step->tasks);
        }
        return $tasks;
    }


}
