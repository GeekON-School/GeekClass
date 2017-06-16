<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseStep;
use Illuminate\Http\Request;

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function details($id)
    {
        $step = CourseStep::findOrFail($id);
        return view('steps.details', compact('step'));
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
        return redirect('/courses/'.$course->id);
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
        return redirect('/lessons/'.$step->id);
    }
}
