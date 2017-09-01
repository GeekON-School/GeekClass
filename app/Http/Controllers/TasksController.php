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

class TasksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('task')->only(['postSolution']);
        $this->middleware('teacher')->only(['create', 'delete', 'editForm', 'edit']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */




    public function create($id, Request $request)
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

    public function delete($id)
    {
        $task = Task::findOrFail($id);
        $step_id = $task->step_id;
        $task->delete();
        return redirect('/insider/lessons/' . $step_id);
    }

    public function editForm($id)
    {
        $task = Task::findOrFail($id);
        return view('steps.edit_task', compact('task'));
    }

    public function edit($id, Request $request)
    {
        $task = Task::findOrFail($id);
        $this->validate($request, [
            'text' => 'required|string',
            'name' => 'required|string',
            'max_mark' => 'required|integer|min:0|max:100'
        ]);
        $task->text = $request->text;
        $task->max_mark = $request->max_mark;
        $task->name = $request->name;
        $task->save();

        $step_id = $task->step_id;
        return redirect('/insider/lessons/' . $step_id. '#task'.$id);
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
