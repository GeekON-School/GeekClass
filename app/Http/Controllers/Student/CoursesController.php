<?php

namespace App\Http\Controllers\Student;

use App\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use \Illuminate\Support\Facades\Auth;

class CoursesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::findOrFail(Auth::User()->id);
        $courses = $user->courses;
        return view('student.home', compact('courses'));
    }
    public function details($id)
    {
        $user = User::findOrFail(Auth::User()->id);
        $course = Course::findOrFail($id);
        if (!$user->courses->contains($course))
            abort(403);
        return view('student.courses.details', compact('course'));
    }
    public function invite(Request $request)
    {
        $user = User::findOrFail(Auth::User()->id);
        $course = Course::where('invite', $request->invite)->first();
        if ($course==null)
        {
            $this->make_error_alert('Ошибка!', 'Курс с таким приглашением не найден.');
            $this->backException();
        }
        $this->make_success_alert('Успех!', 'Вы присоединились к курсу "'.$course->name.'".');
        $course->students()->attach($user->id);
        return redirect()->back();
    }

}
