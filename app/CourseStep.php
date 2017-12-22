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


    protected $next = null;
    protected $previous = null;

    public function load_positions()
    {
        $steps = $this->lesson->steps;
        $i = $steps->pluck('id')->search($this->id);
        $this->previous = null;
        $this->next = null;
        if ($i > 0)
            $this->previous = $steps[$i-1];
        if ($i < count($steps)-1)
            $this->next = $steps[$i + 1];
    }


    protected $results_cache = array();

    public function course()
    {
        return $this->belongsTo('App\Course', 'course_id', 'id');
    }

    public function lesson()
    {
        return $this->belongsTo('App\Lesson', 'lesson_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany('App\Question', 'step_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task', 'step_id', 'id')->orderBy('sort_index')->orderBy('id');
    }
    public function class_tasks()
    {
        return $this->hasMany('App\Task', 'step_id', 'id')->Where('only_remote', false)->orderBy('sort_index')->orderBy('id');
    }
    public function remote_tasks()
    {
        return $this->hasMany('App\Task', 'step_id', 'id')->Where('only_class', false)->orderBy('sort_index')->orderBy('id');
    }

    public function nextStep()
    {
        if ($this->next == null)
            $this->load_positions();

        return $this->next;
    }
    public function previousStep()
    {
        if ($this->previous == null)
            $this->load_positions();
        return $this->previous;
    }

    public static function createStep($lesson, $data)
    {
        $order = 100;
        if ($lesson->steps->count()!=0)
            $order = $lesson->steps->last()->sort_index + 1;

        $step = new CourseStep();
        $step->name = $data['name'];
        $step->notes = $data['notes'];
        $step->theory = $data['theory'];
        $step->course_id = $lesson->course->id;
        $step->lesson_id = $lesson->id;
        $step->sort_index = $order;
        $step->start_date = $lesson->start_date;
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

    public function stats(User $student)
    {
        if (isset($this->results_cache[$student->id]))
        {
            return $this->results_cache[$student->id];
        }
        $results = ['percent'=>0, 'points'=>0, 'max_points'=>0];
        if ($this->course->students->contains($student))
        {
            if ($student->pivot->is_remote)
            {
                $tasks = $this->remote_tasks;
            }
            else {
                $tasks = $this->class_tasks;
            }
            foreach ($tasks as $task)
            {
                if (!$task->is_star) $results['max_points'] += $task->max_mark;
                $results['points'] += $student->submissions()->where('task_id', $task->id)->max('mark');
            }
            if ($results['max_points'] != 0)
            {
                $results['percent'] = $results['points'] * 100 / $results['max_points'];
            }
        }
        $this->results_cache[$student->id] = $results;
        return $results;
    }
    public function percent(User $student)
    {
        return ($this->stats($student))['percent'];
    }
    public function points(User $student)
    {
        return ($this->stats($student))['points'];
    }
    public function max_points(User $student)
    {
        return ($this->stats($student))['max_points'];
    }

}
