<?php

namespace App\Http\Controllers;

use App\Course;
use App\ProgramStep;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\Program;
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
        $program = Course::findOrFail($id)->program;
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $order = 100;
        if ($program->lessons->count()!=0)
            $order = $program->lessons->last()->sort_index + 1;

        $lesson = new Lesson();
        $lesson->name = $request->name;
        $lesson->program_id = $program->id;
        $lesson->sort_index = $order;
        $lesson->description = $request->description;
        $lesson->sticker = "/stickers/".random_int(1, 40).".png";

        $lesson->save();

        foreach ($request->prerequisites as $prerequisite_id) {
            $lesson->prerequisites()->attach($prerequisite_id);
        }

        $data = ['name'=>'Введение', 'theory'=>'', 'notes'=>''];

        $step = ProgramStep::createStep($lesson, $data);

        return redirect('/insider/courses/'.$id.'/steps/' . $step->id);
    }

    public function editView($course_id, $id)
    {

        $lesson = Lesson::findOrFail($id);
        return view('lessons.edit', compact('lesson'));
    }

    public function edit($course_id, $id, Request $request)
    {
        $lesson = Lesson::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required'
        ]);
        foreach ($lesson->prerequisites as $prerequisite) {
            $lesson->prerequisites()->detach($prerequisite->id);
        }
        foreach ($request->prerequisites as $prerequisite_id) {
            $lesson->prerequisites()->attach($prerequisite_id);
        }
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

        return redirect('/insider/courses/' . $course_id);
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
