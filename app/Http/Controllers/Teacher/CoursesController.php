<?php

namespace App\Http\Controllers\Teacher;

use App\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoursesController extends Controller
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
        $courses = Course::all();
        return view('teacher.home', compact('courses'));
    }
    public function details($id)
    {
        $course = Course::findOrFail($id);
        return view('teacher.courses.details', compact('course'));
    }
    public function createView()
    {
        return view('teacher.courses.create');
    }
    public function editView($id)
    {
        $course = Course::findOrFail($id);
        return view('teacher.courses.edit', compact('course'));
    }
    public function start($id)
    {
        $course = Course::findOrFail($id);
        $course->start();
        return redirect('/teacher/courses/'.$course->id);
    }
    public function stop($id)
    {
        $course = Course::findOrFail($id);
        $course->end();
        return redirect('/teacher/courses/'.$course->id);
    }
    public function edit($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpg,png|max:1000'
        ]);

        $course = Course::findOrFail($id);
        $course->name = $request->name;
        $course->description = $request->description;
        if ($request->hasFile('image'))
        {
            $extn = '.'.$request->file('image')->guessClientExtension();
            $path = $request->file('image')->storeAs('course_avatars', $course->id.$extn);
            $course->image = $path;

        }
        $course->save();
        return redirect('/teacher/courses/'.$course->id);
    }
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpg,png|max:1000'
        ]);
        $course = Course::createCourse($request);
        if ($request->hasFile('image'))
        {
            $extn = '.'.$request->file('image')->guessClientExtension();
            $path = $request->file('image')->storeAs('course_avatars', $course->id.$extn);
            $course->image = $path;

        }
        else {
            $course->image = 'course_avatars/blank.png';
        }
        $course->save();
        return redirect('/teacher/courses');
    }
}
