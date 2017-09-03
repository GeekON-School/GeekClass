<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseStep;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
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
    public function index()
    {
        $user  = User::findOrFail(Auth::User()->id);
        $courses = Course::all();
        return view('home', compact('courses', 'user'));
    }
    public function details($id = null)
    {
        $guest  = User::findOrFail(Auth::User()->id);
        $user = null;
        if ($id == null)
        {
            $user = $guest;
        }
        else {
            $user = User::findOrFail(Auth::User()->id);
        }
        return view('profile.details', compact('user', 'guest'));
    }

    public function editView($id)
    {
        $guest  = User::findOrFail(Auth::User()->id);
        $user = User::findOrFail(Auth::User()->id);

        return view('profile.edit', compact('user', 'guest'));
    }

    public function edit($id, Request $request)
    {
        $guest  = User::findOrFail(Auth::User()->id);
        $user = User::findOrFail(Auth::User()->id);

        $this->validate($request, [
            'name' => 'required|string',
            'vk' => 'string',
            'facebook' => 'string',
            'git' => 'string',
            'telegram' => 'string',
            'school' => 'required|string',
            'grade' => 'required|integer',
            'birthday' => 'required|date',
            'hobbies' => 'required|string',
            'interests' => 'required|string',
            'comments' => 'string',
            'image' => 'image|max:1000'
        ]);

        $user->name = $request->name;
        $user->vk = $request->vk;
        $user->git = $request->git;
        $user->facebook = $request->facebook;
        $user->telegram = $request->telegram;
        $user->hobbies = $request->hobbies;
        $user->interests = $request->interests;
        $user->school = $request->school;
        $user->birthday = Carbon::createFromFormat('Y-m-d', $request->birthday);
        $user->setGrade($request->grade);

        if ($request->hasFile('image'))
        {
            $extn = '.'.$request->file('image')->guessClientExtension();
            $path = $request->file('image')->storeAs('user_avatars', $user->id.$extn);
            $user->image = $path;
        }

        if ($guest->role == 'teacher')
            $user->comments = $request->comments;

        $user->save();

        return redirect('/insider/profile/'.$id);
    }
}
