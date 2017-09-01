<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseStep;
use App\Http\Controllers\Controller;
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
        return view('steps.details', compact('step', 'user'));
    }

    public function createView($id)
    {
        $course = Course::findOrFail($id);
        return view('steps.create', compact($course));
    }

    public function create($id, Request $request)
    {
        $course = Course::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
        ]);
        CourseStep::createStep($course, $request);
        return redirect('/insider/courses/' . $course->id);
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
        ]);
        CourseStep::editStep($step, $request);
        return redirect('/insider/lessons/' . $step->id);
    }


}
