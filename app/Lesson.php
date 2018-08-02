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

    public function prerequisites()
    {
        return $this->belongsToMany('App\CoreNode', 'core_prerequisites', "lesson_id", "node_id");
    }

    public function getConsequences()
    {
        $tasks = $this->tasks();

        $consequences = collect([]);
        foreach ($tasks as $task)
        {
            foreach ($task->consequences as $consequence) {
                $consequences->push($consequence);
            }
        }

        return $consequences->unique();
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
    public function export()
    {
        $lesson = Lesson::where('id', $this->id)->with('steps')->first();
        unset($lesson->id);
        unset($lesson->updated_at);
        foreach ($lesson->steps as $key => $step)
        {
            unset($lesson->steps[$key]->id);
            unset($lesson->steps[$key]->updated_at);
            unset($lesson->steps[$key]->lesson_id);
            unset($lesson->steps[$key]->program_id);

            foreach ($lesson->steps[$key]->tasks as $tkey => $task)
            {
                unset($lesson->steps[$key]->tasks[$tkey]->id);
                unset($lesson->steps[$key]->tasks[$tkey]->step_id);
                unset($lesson->steps[$key]->tasks[$tkey]->updated_at);
            }
        }
        return $lesson->toJson();
    }

    public function import($lesson_json)
    {
        $new_lesson = json_decode($lesson_json);
        foreach ($new_lesson->steps as $step)
        {
            $tasks = $step->tasks;
            unset($step->tasks);
            $new_step = new ProgramStep();
            foreach($step as $property => $value)
                $new_step->$property = $value;
            $new_step->lesson_id = $this->id;
            $new_step->program_id = $this->program_id;
            $new_step->save();

            foreach ($tasks as $task)
            {
                $new_task = new Task();
                foreach($task as $property => $value)
                    $new_task->$property = $value;
                $new_task->step_id = $new_step->id;
                $new_task->save();
            }
        }
        $this->save();
    }


}
