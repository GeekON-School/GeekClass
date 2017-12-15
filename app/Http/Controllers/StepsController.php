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
        $this->middleware('teacher')->only(['createView', 'create', 'editView', 'edit', 'makeLower', 'makeUpper', 'perform', 'delete']);

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

        $zero_theory = $step->theory == null || $step->theory == "";
        $one_tasker = $step->tasks->count() == 1 && $zero_theory;
        $empty = $zero_theory && $step->tasks->count() == 0;

        $quizer = true;
        foreach ($tasks as $task)
            if (!$task->is_quiz) $quizer = false;
        $quizer = $quizer && $zero_theory && !$empty;

        return view('steps.details', compact('step', 'user', 'tasks', 'zero_theory', 'one_tasker', 'empty', 'quizer'));
    }

    public function perform($id)
    {
        $user  = User::findOrFail(Auth::User()->id);
        $step = CourseStep::findOrFail($id);
        $tasks = $step->tasks;
        $zero_theory = $step->theory == null || $step->theory == "";
        $one_tasker = $step->tasks->count() == 1;
        $empty = $zero_theory && $step->tasks->count() == 0;
        return view('perform.details', compact('step', 'user', 'tasks','zero_theory', 'one_tasker', 'empty'));
    }

    public function createView($id)
    {
        $is_lesson = false;
        $lesson = Lesson::findOrFail($id);
        return view('steps.create', compact('is_lesson', 'lesson'));
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
            'start_date' => 'date'
        ]);
        CourseStep::editStep($step, $request);
        return redirect('/insider/steps/' . $step->id);
    }

    public function makeLower($id, Request $request)
    {
        $step = CourseStep::findOrFail($id);
        $step->sort_index -= 1;
        $step->save();
        return redirect('/insider/steps/' . $step->id);
    }
    public function makeUpper($id, Request $request)
    {
        $step = CourseStep::findOrFail($id);
        $step->sort_index += 1;
        $step->save();
        return redirect('/insider/steps/' . $step->id);
    }
    public function delete($id)
    {
        $step = CourseStep::findOrFail($id);
        $next = $step->nextStep();
        $pr = $step->previousStep();
        $course_id = $step->course_id;
        $lesson = $step->lesson;

        CourseStep::where('id', $id)->delete();
        if ($pr != null) return redirect('/insider/steps/'.$pr->id);
        if ($next != null) return redirect('/insider/steps/'.$next->id);
        Lesson::where('id', $lesson->id)->delete();
        return redirect('/insider/courses/'.$course_id);
    }


}
