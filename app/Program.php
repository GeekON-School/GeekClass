<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Program extends Model
{
    protected $table = "programs";

    public function courses()
    {
        return $this->hasMany('App\Course', 'course_id', 'id');
    }

    public function steps()
    {
        return $this->hasMany('App\ProgramStep', 'program_id', 'id')->orderBy('sort_index')->orderBy('id');
    }

    public function lessons()
    {
        return $this->hasMany('App\Lesson', 'program_id', 'id')->with('steps')->orderBy('sort_index')->orderBy('id');
    }

    public function authors()
    {
        return $this->belongsToMany('App\User', 'programs_authors', 'program_id', 'user_id');
    }



}
