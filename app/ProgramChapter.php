<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramChapter extends Model
{
    public function program()
    {
        return $this->belongsTo('App\Program', 'program_id', 'id');
    }

    public function lessons()
    {
        return $this->hasMany('App\Lesson', 'chapter_id', 'id')->orderBy('sort_index')->orderBy('id');
    }
}
