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
            if ($node->level == 1) return $line.' '.$node->title;
            $node = $node->parents[0];
            $line .= $node->title.' |';
        }
        $line .= ' '.$node->title;
        return $line;
    }

}
