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
    protected $score = null;
    protected $rank = null;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'school', 'grade_year', 'birthday',
        'hobbies', 'interests', 'git', 'vk', 'telegram', 'facebook', 'comments', 'letter'
    ];
    protected $dates = [
        'birthday'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function managed_courses()
    {
        return $this->belongsToMany('App\Course', 'course_teachers', 'user_id', 'course_id');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Course', 'course_students', 'user_id', 'course_id');
    }
    public function completedCourses()
    {
        return $this->hasMany('App\CompletedCourse', 'user_id', 'id');
    }
    public function submissions()
    {
        return $this->hasMany('App\Solution', 'user_id', 'id');
    }
    public function manual_rank()
    {
        return $this->hasOne('App\Rank', 'id', 'rank_id');
    }
    public function grade()
    {
        $current_year = Carbon::now()->year;
        return $current_year - $this->grade_year+1;
    }
    public function projects()
    {
        return $this->belongsToMany('App\Project', 'project_students', 'user_id', 'project_id');
    }

    public function setGrade($grade)
    {
        $current_year = Carbon::now()->year;
        $date = Carbon::now();
        if ($date->lt(Carbon::createFromDate($current_year, 6,1 )))
        {
            $this->grade_year = $current_year-$grade;
        }
        else {
            $this->grade_year = $current_year-$grade+1;
        }
    }

    public function score()
    {
        if ($this->score!=null)
            return $this->score;
        if ($this->rank_id!=null)
        {
            $this->score = $this->manual_rank->to-1;
            return $this->score;
        }
        $this->score = 0;
        $group = $this->submissions->groupBy('task_id');
        foreach ($group as $task)
        {
            $this->score += $task->max('mark');
        }

        foreach ($this->completedCourses as $course)
        {
            $mark = $course->mark;
            switch ($mark)
            {
                case 'A+':
                    $this->score += 1500;
                    break;
                case 'A':
                    $this->score += 1200;
                    break;
                case 'A-':
                    $this->score += 1000;
                    break;
                case 'B+':
                    $this->score += 800;
                    break;
                case 'B':
                    $this->score += 600;
                    break;
                case 'B-':
                    $this->score += 400;
                    break;
                case 'C+':
                    $this->score += 300;
                    break;
                case 'C':
                    $this->score += 200;
                    break;
                case 'C-':
                    $this->score += 100;
                    break;
                case 'D+':
                    $this->score += 50;
                    break;
                case 'D':
                    $this->score += 50;
                    break;
                case 'D-':
                    $this->score += 50;
                    break;
                default:
                    $this->score += 600;
                    break;
            }
        }
        return $this->score;
    }

    public function rank()
    {
        if ($this->rank!=null)
            return $this->rank;
        if ($this->rank_id!=null)
        {
            $this->rank = $this->manual_rank;
            return $this->rank;
        }
        $score = $this->score();
        $this->rank = Rank::where('from', '<=', $score)->where('to', '>', $score)->first();
        return $this->rank;
    }

    public function eventOrgs()
    {
        return $this->belongsToMany('App\Event', 'event_orgs');
    }

    public function eventPartis()
    {
        return $this->belongsToMany('App\Event', 'event_partis');
    }

    public function eventLikes()
    {
        return $this->belongsToMany('App\Event', 'event_likes');
    }

    public function eventComments()
    {
        return $this->hasMany('App\EventComments');
    }
}
