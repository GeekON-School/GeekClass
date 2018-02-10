<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseStep;
use App\Http\Controllers\Controller;
use App\Provider;
use App\User;
use App\Lesson;
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
        $user = User::findOrFail(Auth::User()->id);
        $courses = Course::orderBy('id')->get();
        $providers = Provider::orderBy('id')->get();
        return view('home', compact('courses', 'user', 'providers'));
    }

    public function details($id)
    {
        $user = User::findOrFail(Auth::User()->id);
        $course = Course::findOrFail($id);
        $students = $course->students;


        $temp_steps = collect([]);
        $lessons = $course->lessons()->where('start_date', '<=', Carbon::now()->setTime(0,0))->get();
        foreach ($lessons as $lesson)
        {

            $temp_steps = $temp_steps->merge($lesson->steps);
        }
        foreach ($students as $key => $value) {
            $students[$key]->percent = 0;
            $students[$key]->max_points = 0;
            $students[$key]->points = 0;
            foreach ($temp_steps as $step) {
                if ($value->pivot->is_remote) {
                    $tasks = $step->remote_tasks;
                } else {
                    $tasks = $step->class_tasks;
                }
                foreach ($tasks as $task) {
                    if (!$task->is_star) $students[$key]->max_points += $task->max_mark;
                    $students[$key]->points += $value->submissions()->where('task_id', $task->id)->max('mark');
                }
            }
            if ($students[$key]->max_points != 0) {
                $students[$key]->percent = min(100, $students[$key]->points * 100 / $students[$key]->max_points);
            }
        }
        if ($user->role == 'student') {
            $lessons = $course->lessons()->where('start_date', '<=', Carbon::now()->setTime(0,0))->get();

            $steps = $temp_steps;
            $cstudent = $students->filter(function ($value, $key) use ($user) {
                return $value->id == $user->id;
            })->first();
        }
        else {
            $steps = $temp_steps;
            $lessons = $course->lessons;
        }




        return view('courses.details', compact('course', 'user', 'steps', 'students', 'cstudent', 'lessons'));
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
        return redirect('/insider/courses/' . $course->id);
    }

    public function stop($id)
    {
        $course = Course::findOrFail($id);
        $course->end();
        return redirect('/insider/courses/' . $course->id);
    }

    public function edit($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $course = Course::findOrFail($id);
        $course->name = $request->name;
        $course->description = $request->description;
        $course->git = $request->git;
        $course->site = $request->site;
        $course->image = $request->image;
        $course->telegram = $request->telegram;
        /*if ($request->hasFile('image')) {
            $extn = '.' . $request->file('image')->guessClientExtension();
            $path = $request->file('image')->storeAs('course_avatars', $course->id . $extn);
            $course->image = $path;

        }*/
        if ($request->hasFile('import'))
        {
            $json = file_get_contents($request->file('import')->getRealPath());

            $course->import($json);
        }

        $course->save();
        return redirect('/insider/courses/' . $course->id);
    }

    public function create(Request $request)
    {
        $user = User::findOrFail(Auth::User()->id);
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|max:1000'
        ]);
        $course = Course::createCourse($request);
        if ($request->hasFile('image')) {
            $extn = '.' . $request->file('image')->guessClientExtension();
            $path = $request->file('image')->storeAs('course_avatars', $course->id . $extn);
            $course->image = $path;

        } else {
            $course->image = 'course_avatars/blank.png';
        }
        $course->provider_id = $user->provider_id;
        $course->save();
        return redirect('/insider/courses');
    }

    public function invite(Request $request)
    {
        if ($request->invite == null || $request->invite == "") {
            $this->make_error_alert('Ошибка!', 'Курс с таким приглашением не найден.');
            return $this->backException();
        }
        $user = User::findOrFail(Auth::User()->id);
        $course = Course::where('invite', $request->invite)->first();
        $remote = false;
        if ($course == null) {
            $course = Course::where('remote_invite', $request->invite)->first();
            $remote = true;
        }

        if ($course == null) {
            $this->make_error_alert('Ошибка!', 'Курс с таким приглашением не найден.');
            return $this->backException();
        }

        if ($course->students->contains($user)) {
            $this->make_error_alert('Ошибка!', 'Вы уже зачислены на курс "' . $course->name . '".');
            return $this->backException();
        }
        $this->make_success_alert('Успех!', 'Вы присоединились к курсу "' . $course->name . '".');
        $course->students()->attach([$user->id => ['is_remote' => $remote]]);


        return redirect()->back();
    }

    public function export($id)
    {
        $course = Course::findOrFail($id);

        $json = $course->export();

        $response = \Response::make($json);
        $response->header('Content-Type', 'application/json');
        $response->header('Content-length', strlen($json));
        $response->header('Content-Disposition', 'attachment; filename=course-' . $id.'.json');

        return $response;

    }
}
