<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseStep;
use App\Http\Controllers\Controller;
use App\Question;
use App\QuestionVariant;
use App\Solution;
use App\Task;
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
    /*
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
    */
    public function task($id, Request $request)
    {
        $step = CourseStep::findOrFail($id);
        $this->validate($request, [
            'text' => 'required|string',
            'name' => 'required|string',
            'max_mark' => 'required|integer|min:0|max:100'
        ]);
        $task = Task::create(['text' => $request->text, 'step_id'=>$step->id, 'name'=>$request->name, 'max_mark'=>$request->max_mark]);

        return redirect('/insider/lessons/' . $step->id.'#task'.$task->id);
    }
    /*
    public function deleteQuestion($id)
    {
        $question = Question::findOrFail($id);
        $step_id = $question->step_id;
        $question->delete();
        return redirect('/insider/lessons/' . $step_id . '#tasks');
    }*/

    public function deleteTask($id)
    {
        $task = Task::findOrFail($id);
        $step_id = $task->step_id;
        $task->delete();
        return redirect('/insider/lessons/' . $step_id);
    }


    public function postSolution($id, Request $request)
    {
        $task = Task::findOrFail($id);
        $this->validate($request, [
            'text' => 'required|string',
        ]);

        $step_id = $task->step_id;

        $solution = new Solution();
        $solution->task_id = $id;
        $solution->user_id=Auth::User()->id;
        $solution->submitted = Carbon::now();
        $solution->text = $request->text;
        $solution->save();

        return redirect('/insider/lessons/' . $step_id. '#task'.$id);
    }
}
