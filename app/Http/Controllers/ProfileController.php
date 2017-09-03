<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseStep;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use phpDocumentor\Reflection\Project;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user  = User::findOrFail(Auth::User()->id);
        $courses = Course::all();
        return view('home', compact('courses', 'user'));
    }
    public function details($id = null)
    {
        $guest  = User::findOrFail(Auth::User()->id);
        $user = null;
        if ($id == null)
        {
            $user = $guest;
        }
        else {
            $user = User::findOrFail(Auth::User()->id);
        }
        //$projects = $user->projects;
        return view('profile.details', compact('user', 'guest'/**, 'projects'*/));
    }
}
