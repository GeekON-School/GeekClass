<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    protected $table = "courses";

    protected $fillable = [
        'name', 'description', 'image', 'start_date', 'end_date', 'state', 'level', 'invite'
    ];

    protected $dates = [
        'start_date', 'end_date'
    ];

    public function students()
    {
        return $this->belongsToMany('App\User', 'course_students', 'course_id', 'user_id')->withPivot('is_remote');
    }

    public function provider()
    {
        return $this->hasOne('App\Provider',  'id', 'provider_id');
    }

    public function teachers()
    {
        return $this->belongsToMany('App\User', 'course_teachers', 'course_id', 'user_id');
    }

    public function steps()
    {
        return $this->hasMany('App\CourseStep', 'course_id', 'id')->orderBy('id');
    }

    public static function createCourse($data)
    {
        $course = Course::create(['name' => $data['name'], 'description' => $data['description']]);
        $course->teachers()->attach(Auth::User()->id);
        return $course;
    }

    public function start()
    {
        $this->state = 'started';
        $this->start_date = Carbon::now();
        do {
            $invite = str_random(8);
        } while (Course::where('invite', $invite)->count() != 0);
        $this->invite = $invite;
        $this->remote_invite = $invite.'-R';
        $this->save();
    }

    public function end()
    {
        $this->state = 'ended';
        $this->end_date = Carbon::now();
        $this->save();
    }
}
