<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'school', 'grade_year', 'birthday',
        'hobbies', 'interests', 'git', 'vk', 'telegram', 'facebook', 'comments', 'letter'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function courses()
    {
        return $this->belongsToMany('App\Course', 'course_students', 'user_id', 'course_id');
    }
    public function submissions()
    {
        return $this->hasMany('App\Solution', 'user_id', 'id');
    }
    public function grade()
    {
        $current_year = Carbon::now()->year;
        return $current_year - $this->grade_year+1;
    }
    public function setGrade($grade)
    {
        $current_year = Carbon::now()->year;
        $date = Carbon::now();
        if ($date->lt(Carbon::createFromDate($current_year, 6,1 )))
        {
            $this->grade = $current_year-$grade;
        }
        else {
            $this->grade = $current_year-$grade+1;
        }
    }


}
