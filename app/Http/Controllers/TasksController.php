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
use Notification;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

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
        $this->middleware('teacher')->only(['create', 'delete', 'editForm', 'edit', 'reviewSolutions', 'estimateSolution', 'phantomSolution']);
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
        $order = 100;
        if ($step->lesson->steps->count()!=0)
            $order = $step->lesson->steps->last()->sort_index + 1;

        $task = Task::create(['text' => $request->text, 'step_id'=>$step->id, 'name'=>$request->name, 'max_mark'=>$request->max_mark, 'sort_index'=>$order,
            'is_star' => $request->is_star=='on'?true:false,
            'only_remote' => $request->only_remote=='on'?true:false,
            'only_class' => $request->only_class=='on'?true:false]);

        if ($request->has('answer'))
        {
            $task->is_quiz = true;
            $task->answer = $request->answer;
        }
        else if ($request->has('code_answer')) {
            $task->is_code = true;
            $task->checker = $request->checker;
            $task->code_answer = $request->code_answer;
            $task->code_input = $request->code_input;
            $task->template = $request->template;
        }
        $task->save();

        return redirect('/insider/steps/' . $step->id.'#task'.$task->id);
    }

    public function delete($id)
    {
        $task = Task::findOrFail($id);
        $step_id = $task->step_id;
        $task->delete();
        return redirect('/insider/steps/' . $step_id);
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
        if ($request->is_star=='on')
        {
            $task->is_star = true;
        }
        else
        {
            $task->is_star = false;
        }
        if ($request->only_class=='on')
        {
            $task->only_class = true;
        }
        else
        {
            $task->only_class = false;
        }
        if ($request->only_remote=='on')
        {
            $task->only_remote = true;
        }
        else
        {
            $task->only_remote = false;
        }
        if ($request->has('answer'))
        {
            $task->is_quiz = true;
            $task->answer = $request->answer;
        }
        else {
            $task->is_quiz = false;
        }
        if ($request->has('code_answer')) {
            $task->is_quiz = false;
            $task->is_code = true;
            $task->checker = $request->checker;
            $task->code_answer = $request->code_answer;
            $task->code_input = $request->code_input;
            $task->template = $request->template;
        }
        else {
            $task->is_code = false;
        }


        $task->save();

        $step_id = $task->step_id;
        return redirect('/insider/steps/' . $step_id. '#task'.$id);
    }

    public function phantomSolution($id, Request $request)
    {
        $task = Task::findOrFail($id);
        foreach ($task->step->course->students as $user)
        {
            $solution = new Solution();
            $solution->task_id = $id;
            $solution->user_id=$user->id;
            $solution->submitted = Carbon::now();
            $solution->text = " ";
            $solution->save();
        }

        return redirect('/insider/steps/' . $task->step->id. '#task'.$id);
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

        if ($task->is_quiz)
        {
            if ($task->answer==$request->text)
            {
                $solution->mark = $task->max_mark;
                $solution->comment = "Правильно.";

            }
            else {
                $solution->mark = 0;
                $solution->comment = "Неверный ответ.";
            }
            $solution->teacher_id = $task->Step->Course->Teachers->first()->id;
            $solution->checked = Carbon::now();
        }
        if ($task->is_code)
        {
            $solution->text = $request->text;

            $client = new Client();
            $res = $client->post('https://checker.geekclass.ru', ['form_params' =>  ['pswd'=>'GEEK_PSWD_{{}}', 'input'=>$task->code_input, 'code'=>$solution->text, 'checker'=>$task->checker]]);
            if ($res->getStatusCode()!=200)
            {
                $solution->mark = 0;
                $solution->comment = "Ошибка проверки, попробуйте еще раз чуть позже..";
            }
            $data = \GuzzleHttp\json_decode($res->getBody());
            if ($data->state=='general error')
            {
                $solution->mark = 0;
                $solution->comment = "Ошибка проверки, попробуйте еще раз чуть позже.";
            }
            if ($data->state=='error')
            {
                $solution->mark = 0;
                $solution->comment = "Ошибка в программе:<br><br>".nl2br($data->error);
            }
            if ($data->state=='success')
            {
                if (str_contains($data->result, $task->code_answer))
                {
                    $solution->mark = $task->max_mark;
                    $solution->comment = "Правильно.";
                }
                else{
                    $solution->mark = 0;
                    $solution->comment = "Неверное решение.";
                }
            }
            $solution->teacher_id = $task->Step->Course->Teachers->first()->id;
            $solution->checked = Carbon::now();

        }

        $solution->save();

        if (!$task->is_quiz && !$task->is_code)
        {
            $when = \Carbon\Carbon::now()->addSeconds(1);
            Notification::send($task->step->course->teachers, (new \App\Notifications\NewSolution($solution))->delay($when));
        }

        return redirect('/insider/steps/' . $step_id. '#task'.$id);
    }
    public function reviewSolutions($id, $student_id, Request $request)
    {
        $task = Task::findOrFail($id);
        $student = User::findOrFail($student_id);
        $solutions = $task->solutions->filter(function ($value) use ($student) {
            return $value->user_id == $student->id;
        });
        return view('steps.review', compact('task', 'student', 'solutions'));
    }
    public function estimateSolution($id, Request $request)
    {
        $solution = Solution::findOrFail($id);
        $this->validate($request, [
            'mark' => 'required|integer|min:0|max:'.$solution->task->max_mark
        ]);
        $solution->mark = $request->mark;
        $solution->comment = $request->comment;
        $solution->teacher_id = Auth::User()->id;
        $solution->checked = Carbon::now();
        $solution->save();

        $when = \Carbon\Carbon::now()->addSeconds(1);
        Notification::send($solution->user, (new \App\Notifications\NewMark($solution))->delay($when));

        return redirect()->back();

    }

    public function makeLower($id, Request $request)
    {
        $task = Task::findOrFail($id);
        $task->sort_index -= 1;
        $task->save();
        return redirect('/insider/steps/' . $task->step->id. '#task'.$id);
    }
    public function makeUpper($id, Request $request)
    {
        $task = Task::findOrFail($id);
        $task->sort_index += 1;
        $task->save();
        return redirect('/insider/steps/' . $task->step->id. '#task'.$id);
    }
    public function toNextTask($id, Request $request)
    {
        $task = Task::findOrFail($id);
        $next = $task->step->nextStep();
        if ($next!=null)
        {
            $task->step_id = $next->id;
            $task->save();
            return redirect('/insider/steps/' . $next->id. '#task'.$id);
        }

        return redirect('/insider/steps/' . $task->step->id. '#task'.$id);
    }
    public function toPreviousTask($id, Request $request)
    {
        $task = Task::findOrFail($id);
        $previous = $task->step->previousStep();
        if ($previous!=null)
        {
            $task->step_id = $previous->id;
            $task->save();
            return redirect('/insider/steps/' . $previous->id. '#task'.$id);
        }

        return redirect('/insider/steps/' . $task->step->id. '#task'.$id);
    }
}
