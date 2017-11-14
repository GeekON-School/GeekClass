<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseStep;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\Question;
use App\QuestionVariant;
use App\Solution;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class StepsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('step')->only(['details']);
        $this->middleware('teacher')->only(['createView', 'create', 'editView', 'edit']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function details($id)
    {
        $user  = User::findOrFail(Auth::User()->id);
        $step = CourseStep::findOrFail($id);

        if ($user->role=='teacher')
        {
            $tasks = $step->tasks;
        }
        else {
            $student = $step->course->students->filter(function($value, $key) use ($user)  {
                return $value->id == $user->id;
            })->first();
            if ($student->pivot->is_remote)
            {
                $tasks = $step->remote_tasks;
            }
            else {
                $tasks = $step->class_tasks;
            }
        }
        return view('steps.details', compact('step', 'user', 'tasks'));
    }

    public function createView($id)
    {
        $is_lesson = false;
        $lesson = Lesson::findOrFail($id);
        return view('steps.create', compact('is_lesson', 'lesson'));
    }
    public function createLessonView($id)
    {
        $is_lesson = true;
        return view('steps.create', compact('is_lesson'));
    }

    public function create($id, Request $request)
    {
        $lesson = Lesson::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string',
        ]);
        $step = CourseStep::createStep($lesson, $request);

        return redirect('/insider/steps/' . $step->id);
    }

    public function createLesson($id, Request $request)
    {
        $course = Course::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string',
            'lesson_name' => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required|date|date_format:Y-m-d'
        ]);

        $lesson = new Lesson();
        $lesson->start_date = Carbon::createFromFormat('Y-m-d', $request['start_date']);
        $lesson->name = $request->lesson_name;
        $lesson->course_id = $course->id;
        $lesson->description = $request->descrition;
        $lesson->save();

        $step = CourseStep::createStep($lesson, $request);

        return redirect('/insider/steps/' . $step->id);
    }

    public function editView($id)
    {
        $step = CourseStep::findOrFail($id);
        return view('steps.edit', compact('step'));
    }

    public function edit($id, Request $request)
    {
        $step = CourseStep::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'start_date' => 'date'
        ]);
        CourseStep::editStep($step, $request);
        return redirect('/insider/steps/' . $step->id);
    }


}
