<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseStep;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class CoursesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('course')->only(['details']);
        $this->middleware('teacher')->only(['createView', 'editView', 'start', 'stop', 'edit', 'create', 'assesments']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user  = User::findOrFail(Auth::User()->id);
        $courses = Course::orderBy('id')->get();
        return view('home', compact('courses', 'user'));
    }
    public function details($id)
    {
        $user  = User::findOrFail(Auth::User()->id);
        $course = Course::findOrFail($id);
        $points = 0;
        $max_points = 0;
        $percent = 0;
        if ($user->role=='student')
        {
            $steps = $course->steps()->where('start_date', '<=', Carbon::now())->orWhere('start_date', null)->get();
            foreach ($steps as $step)
            {
                foreach ($step->tasks as $task)
                {
                    if (!$task->is_star) $max_points += $task->max_mark;
                    $points += $user->submissions()->where('task_id', $task->id)->max('mark');
                }
            }
            if ($max_points!=0)
            {
                $percent = min(100,$points * 100 / $max_points);
            }

        }
        else{
            $steps = $course->steps;
        }
        return view('courses.details', compact('course', 'user', 'steps', 'percent', 'points', 'max_points'));
    }
    public function assessments($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.assessments', compact('course'));
    }

    public function createView()
    {
        return view('courses.create');
    }
    public function editView($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.edit', compact('course'));
    }
    public function start($id)
    {
        $course = Course::findOrFail($id);
        $course->start();
        return redirect('/insider/courses/'.$course->id);
    }
    public function stop($id)
    {
        $course = Course::findOrFail($id);
        $course->end();
        return redirect('/insider/courses/'.$course->id);
    }
    public function edit($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpg,png|max:1000'
        ]);

        $course = Course::findOrFail($id);
        $course->name = $request->name;
        $course->description = $request->description;
        if ($request->has('git'))
            $course->git = $request->git;
        if ($request->has('telegram'))
            $course->telegram = $request->telegram;
        if ($request->hasFile('image'))
        {
            $extn = '.'.$request->file('image')->guessClientExtension();
            $path = $request->file('image')->storeAs('course_avatars', $course->id.$extn);
            $course->image = $path;

        }
        $course->save();
        return redirect('/insider/courses/'.$course->id);
    }
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|max:1000'
        ]);
        $course = Course::createCourse($request);
        if ($request->hasFile('image'))
        {
            $extn = '.'.$request->file('image')->guessClientExtension();
            $path = $request->file('image')->storeAs('course_avatars', $course->id.$extn);
            $course->image = $path;

        }
        else {
            $course->image = 'course_avatars/blank.png';
        }
        $course->save();
        return redirect('/insider/courses');
    }
    public function invite(Request $request)
    {
        if ($request->invite==null || $request->invite=="")
        {
            $this->make_error_alert('Ошибка!', 'Курс с таким приглашением не найден.');
            return $this->backException();
        }
        $user = User::findOrFail(Auth::User()->id);
        $course = Course::where('invite', $request->invite)->first();
        if ($course==null)
        {
            $this->make_error_alert('Ошибка!', 'Курс с таким приглашением не найден.');
            return $this->backException();
        }
        if ($course->students->contains($user))
        {
            $this->make_error_alert('Ошибка!', 'Вы уже зачислены на курс "'.$course->name.'".');
            return $this->backException();
        }
        $this->make_success_alert('Успех!', 'Вы присоединились к курсу "'.$course->name.'".');
        $course->students()->attach($user->id);
        return redirect()->back();
    }
}
