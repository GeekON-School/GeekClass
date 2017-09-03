<?php
/**
 * Created by PhpStorm.
 * User: AlexNerru
 * Date: 03.09.2017
 * Time: 23:22
 */

namespace App\Http\Controllers;


class ProjectsController
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('creator')->only(['createProject, editProject']);
    }
    #TODO change it
    public function details($id)
    {
        $user  = User::findOrFail(Auth::User()->id);
        $course = Course::findOrFail($id);
        if ($user->role=='student')
        {
            $steps = $course->steps()->where('start_date', '>=', Carbon::now())->orWhere('start_date', null)->get();
        }
        else{
            $steps = $course->steps;
        }
        return view('courses.details', compact('course', 'user', 'steps'));
    }
}