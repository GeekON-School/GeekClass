<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoreNode extends Model
{
    protected $table = 'core_nodes';
    public $timestamps = false;

    public function parents()
    {
        return $this->belongsToMany('App\CoreNode', 'core_edges', "to_id", "from_id");
    }
    public function children()
    {
        return $this->belongsToMany('App\CoreNode', 'core_edges', "from_id", "to_id");
    }

    public function fromEdges()
    {
        return $this->hasMany('App\CoreEdge', 'from_id', 'id');
    }

    public function toEdges()
    {
        return $this->hasMany('App\CoreEdge', 'to_id', 'id');
    }

}
