<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseStep extends Model
{
    protected $table = 'course_steps';

    protected $fillable = [
        'name', 'description', 'image', 'activation_date'
    ];

    protected $dates = [
        'activation_date'
    ];

    public function course()
    {
        return $this->belongsTo('App\Course', 'course_id', 'id');
    }
}
