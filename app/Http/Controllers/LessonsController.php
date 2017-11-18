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

class LessonsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('teacher')->only(['createView', 'create', 'editView', 'edit', 'makeLower', 'makeUpper']);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function createView($id)
    {
        return view('lessons.create');
    }

    public function create($id, Request $request)
    {
        $course = Course::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required|date|date_format:Y-m-d'
        ]);
        $lesson = new Lesson();
        $lesson->start_date = Carbon::createFromFormat('Y-m-d', $request['start_date']);
        $lesson->name = $request->name;
        $lesson->course_id = $course->id;
        $lesson->description = $request->description;

        $lesson->save();

        $data = ['name'=>'Введение', 'theory'=>'', 'notes'=>''];

        $step = CourseStep::createStep($lesson, $data);

        return redirect('/insider/steps/' . $step->id);
    }

    public function editView($id)
    {
        $lesson = Lesson::findOrFail($id);
        return view('lessons.edit', compact('lesson'));
    }

    public function edit($id, Request $request)
    {
        $lesson = Lesson::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string',
            'start_date' => 'required|date|date_format:Y-m-d',
            'description' => 'required'
        ]);
        $lesson->name = $request->name;
        $lesson->start_date = $request->start_date;
        $lesson->description = $request->description;
        $lesson->save();
        return redirect('/insider/courses/' . $lesson->course->id);
    }




}
