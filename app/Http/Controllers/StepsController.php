<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseStep;
use App\Http\Controllers\Controller;
use App\Question;
use App\QuestionVariant;
use App\Task;
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

    public function question($id, Request $request)
    {
        $step = CourseStep::findOrFail($id);
        $this->validate($request, [
            'text' => 'required|string',
        ]);
        $question = Question::create(['text' => $request->text, 'step_id'=>$step->id]);
        foreach ($request->variants as $elem) {
            $variant = new QuestionVariant();
            $variant->text = $elem['text'];
            if (array_key_exists ('is_correct', $elem))
            {
                $variant->is_correct = true;
            }
            $variant->question_id = $question->id;
            $variant->save();
        }
        return redirect('/insider/lessons/' . $step->id);
    }

    public function task($id, Request $request)
    {
        $step = CourseStep::findOrFail($id);
        $this->validate($request, [
            'text' => 'required|string',
            'name' => 'required|string',
        ]);
        $task = Task::create(['text' => $request->text, 'step_id'=>$step->id, 'name'=>$request->name]);

        return redirect('/insider/lessons/' . $step->id.'#tasks');
    }

    public function deleteQuestion($id)
    {
        $question = Question::findOrFail($id);
        $step_id = $question->step_id;
        $question->delete();
        return redirect('/insider/lessons/' . $step_id);
    }

    public function deleteTask($id)
    {
        $task = Task::findOrFail($id);
        $step_id = $task->step_id;
        $task->delete();
        return redirect('/insider/lessons/' . $step_id);
    }
}
