<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoreNode extends Model
{
    protected $table = 'core_nodes';
    public $timestamps = false;

    public function lessons()
    {
        return $this->belongsToMany('App\Lesson', 'core_prerequisites', "node_id", "lesson_id");
    }

    public function tasks()
    {
        return $this->belongsToMany('App\Task', 'core_consequences', "node_id", "task_id");
    }

    public function children()
    {
        return $this->belongsToMany('App\CoreNode', 'core_edges', "to_id", "from_id")->wherePivot('type', 'partOf');
    }

    public function connections()
    {
        return $this->belongsToMany('App\CoreNode', 'core_edges', "to_id", "from_id")->wherePivot('type', 'relates');
    }

    public function parents()
    {
        return $this->belongsToMany('App\CoreNode', 'core_edges', "from_id", "to_id")->wherePivot('type', 'partOf');
    }

    public function getCluster()
    {
        return CoreNode::where('cluster', $this->cluster)->where('level', 2)->first();
    }

    public function fromEdges()
    {
        return $this->hasMany('App\CoreEdge', 'from_id', 'id');
    }

    public function toEdges()
    {
        return $this->hasMany('App\CoreEdge', 'to_id', 'id');
    }

    public function getParentLine()
    {
        if ($this->level == 1) return '';
        $line = '';
        $node = $this;
        for ($i = 0; $i < 2; $i++)
        {
            if ($node->level == 2) return $line.$node->parents[0]->title;
            $node = $node->parents[0];
            $line .= $node->title.'&nbsp;&raquo;&nbsp;';
        }
        $line .= $node->parents[0]->title;
        return $line;
    }

    public function getRelatedLessonsHTML()
    {
        $tasks = $this->tasks;
        $user = User::findOrFail(\Auth::User()->id);
        $result = '<p><small><ul>';
        foreach ($tasks as $task)
        {
            if ($user->role=='teacher')
            {
                $course = Course::where('program_id', $task->step->program->id)->orderBy('id', 'DESC')->first();

            }
            else {
                $course = $user->courses()->where('program_id', $task->step->program->id)->first();
            }

            if ($course==null)
            {
                $result .= "<li>".$task->step->name." (".$task->step->program->name.")</li>";
            }
            else {
                $result .= "<li><a target='_blank' href='".url('/insider/courses/'.$course->id.'/steps/'.$task->step->id)."'>".$task->step->name." (".$task->step->program->name.")</a></li>";
            }
        }
        $result .= '</small></ul></p>';
        return $result;
    }

}
