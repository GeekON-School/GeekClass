<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompletedCourse extends Model
{
    protected $table = 'completed_courses';

    public $timestamps = false;

    protected $fillable = [
        'mark', 'name', 'provider', 'class'
    ];



}
