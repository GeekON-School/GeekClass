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

        if ($request->hasFile('import') && $request->file('import')->getClientMimeType() == 'application/json')
        {
            $json = file_get_contents($request->file('import')->getRealPath());
            $new_lesson = json_decode($json)[0];
            foreach ($new_lesson->steps as $step)
            {
                $tasks = $step->tasks;
                unset($step->tasks);
                $new_step = new CourseStep();
                foreach($step as $property => $value)
                    $new_step->$property = $value;
                $new_step->id = null;
                $new_step->created_at = null;
                $new_step->updated_at = null;
                $new_step->lesson_id = $lesson->id;
                $new_step->course_id = $lesson->course_id;
                $new_step->save();
                
                foreach ($tasks as $task)
                {
                    $new_task = new Task();
                    foreach($task as $property => $value)
                        $new_task->$property = $value;
                    $new_task->id = null;
                    $new_task->created_at = null;
                    $new_task->updated_at = null;
                    $new_task->step_id = $new_step->id;
                    $new_task->save();
                }
            }
        }

        $lesson->save();
        return redirect('/insider/courses/' . $lesson->course->id);
    }

    public function export($id)
    {
        $lesson = Lesson::where('id', $id)->with('steps')->get();
        if ($lesson == null) abort(404);

        $json = $lesson->toJson();

        $response = \Response::make($json);
        $response->header('Content-Type', 'application/json');
        $response->header('Content-length', strlen($json));
        $response->header('Content-Disposition', 'attachment; filename=lesson-' . $id.'.json');

        return $response;

    }





}
