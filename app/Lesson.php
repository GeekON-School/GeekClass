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
        return $this->hasMany('App\CourseStep', 'lesson_id', 'id')->orderBy('id');
    }

}
