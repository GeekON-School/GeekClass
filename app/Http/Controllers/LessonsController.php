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
        $this->middleware('teacher')->only(['createView', 'create', 'editView', 'edit', 'makeLower', 'makeUpper', 'export']);

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

        $order = 100;
        if ($course->lessons->count()!=0)
            $order = $course->lessons->last()->sort_index + 1;

        $lesson = new Lesson();
        $lesson->start_date = Carbon::createFromFormat('Y-m-d', $request['start_date']);
        $lesson->name = $request->name;
        $lesson->course_id = $course->id;
        $lesson->sort_index = $order;
        $lesson->description = $request->description;
        $lesson->sticker = "/stickers/".random_int(1, 40).".png";

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
        if ($request->open == "yes")
            $lesson->is_open = true;
        else
            $lesson->is_open = false;
        $lesson->save();

        if ($request->hasFile('import') && $request->file('import')->getClientMimeType() == 'application/json')
        {
            $json = file_get_contents($request->file('import')->getRealPath());
            $lesson->import($json);
        }

        return redirect('/insider/courses/' . $lesson->course->id);
    }

    public function makeLower($id, Request $request)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->sort_index -= 1;
        $lesson->save();
        return redirect('/insider/courses/' . $lesson->course->id);
    }
    public function makeUpper($id, Request $request)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->sort_index += 1;
        $lesson->save();
        return redirect('/insider/courses/' . $lesson->course->id);
    }

    public function export($id)
    {
        $lesson = Lesson::findOrFail($id);

        $json = $lesson->export();

        $response = \Response::make($json);
        $response->header('Content-Type', 'application/json');
        $response->header('Content-length', strlen($json));
        $response->header('Content-Disposition', 'attachment; filename=lesson-' . $id.'.json');

        return $response;

    }





}
