<?php

namespace App\Http\Controllers;

use App\ActionLog;
use App\CompletedCourse;
use App\Course;
use App\ForumThread;
use App\Program;
use App\ProgramChapter;
use App\ProgramStep;
use App\Http\Controllers\Controller;
use App\Provider;
use App\Solution;
use App\User;
use App\Lesson;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

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
        $this->middleware('course')->only(['details']);
        $this->middleware('teacher')->only(['createView', 'editView', 'start', 'stop', 'edit', 'create', 'assessments', 'report', 'createChapter', 'editChapter', 'createChapterView', 'editChapterView
       ']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::findOrFail(Auth::User()->id);
        $users = User::where('is_hidden', false)->get();
        $courses = Course::orderBy('id')->get();
        $providers = Provider::orderBy('id')->get();
        $threads = ForumThread::orderBy('id', 'DESC')->limit(5)->get();
        return view('home', compact('courses', 'user', 'providers', 'users', 'threads'));
    }

    public function report($id)
    {
        $user = User::with('solutions', 'solutions.task', 'solutions.task.consequences')->findOrFail(Auth::User()->id);
        $course = Course::with('program.lessons', 'students', 'students.submissions', 'teachers', 'program.steps', 'program.lessons.prerequisites', 'program.lessons.info')->findOrFail($id);
        $students = $course->students;
        $marks = CompletedCourse::where('course_id', $id)->get();
        $steps = $course->steps;
        $temp_steps = collect([]);
        $lessons = $course->lessons->filter(function ($lesson) use ($course) {
            return $lesson->isStarted($course);
        });

        foreach ($lessons as $lesson) {
            $temp_steps = $temp_steps->merge($lesson->steps);
        }

        /* count pulse */

        $ids = $students->map(function ($item, $key) {
            return $item->id;
        })->values();

        $steps_ids = $temp_steps->map(function ($item, $key) {
            return $item->id;
        })->values();


        $use_records = ActionLog::where('created_at', '>', Carbon::now()->addWeeks(-2))->whereIn('user_id', $ids)->get()->filter(function ($item) use ($steps_ids, $course) {
            return ($item->type == 'course' and $item->object_id == $course->id) or ($item->type == 'step' and $steps_ids->contains($item->object_id));
        })->groupBy('user_id')->map(function ($item) {
            return $item->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            })->map(function ($item) {
                return $item->count();
            });
        });

        $pulse_keys = collect([]);
        $pulse_values = collect([]);


        foreach ($use_records as $student_id => $value) {
            $first_hour = Carbon::createFromFormat('Y-m-d', $value->keys()[0]);

            while ($first_hour->lt(Carbon::now())) {
                $first_hour->addHour();
                if (!$value->has($first_hour->format('Y-m-d'))) {
                    $use_records[$student_id][$first_hour->format('Y-m-d')] = 0;
                }
            }

            $use_records[$student_id] = $use_records[$student_id]->sortBy(function ($item, $key) {
                return Carbon::createFromFormat('Y-m-d', $key);
            });

            $pulse_keys[$student_id] = '[\'' . implode('\', \'', $use_records[$student_id]->keys()->toArray()) . '\']';
            $pulse_values[$student_id] = '[\'' . implode('\', \'', $use_records[$student_id]->values()->toArray()) . '\']';
        }

        $task_records = $course->solutions->where('created_at', '>', Carbon::now()->addWeeks(-2))->groupBy('user_id')->map(function ($item) {
            return $item->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            })->map(function ($item) {
                return $item->sum('mark');
            });
        });

        $task_keys = collect([]);
        $task_values = collect([]);


        foreach ($task_records as $student_id => $value) {
            $first_hour = Carbon::now()->addWeeks(-2);

            while ($first_hour->lt(Carbon::now())) {
                $first_hour->addDay();
                if (!$value->has($first_hour->format('Y-m-d'))) {
                    $task_records[$student_id][$first_hour->format('Y-m-d')] = 0;
                }
            }

            $task_records[$student_id] = $task_records[$student_id]->sortBy(function ($item, $key) {
                return Carbon::createFromFormat('Y-m-d', $key);
            });

            $task_keys[$student_id] = '[\'' . implode('\', \'', $task_records[$student_id]->keys()->toArray()) . '\']';
            $task_values[$student_id] = '[\'' . implode('\', \'', $task_records[$student_id]->values()->toArray()) . '\']';
        }


        foreach ($students as $key => $value) {
            $students[$key]->percent = 0;
            $students[$key]->max_points = 0;
            $students[$key]->points = 0;
            foreach ($temp_steps as $step) {
                if ($value->pivot->is_remote) {
                    $tasks = $step->remote_tasks;
                } else {
                    $tasks = $step->class_tasks;
                }

                foreach ($tasks as $task) {
                    if (!$task->is_star) $students[$key]->max_points += $task->max_mark;
                    $students[$key]->points += $value->submissions->where('task_id', $task->id)->max('mark');
                }


            }
            if ($students[$key]->max_points != 0) {
                $students[$key]->percent = min(100, $students[$key]->points * 100 / $students[$key]->max_points);
            }
        }

        return view('courses.report', compact('course', 'user', 'steps', 'students', 'lessons', 'marks', 'pulse_keys', 'pulse_values', 'task_keys', 'task_values'));


    }

    public function details($id, Request $request)
    {

        \App\ActionLog::record(Auth::User()->id, 'course', $id);

        $user = User::with('solutions', 'solutions.task', 'solutions.task.consequences')->findOrFail(Auth::User()->id);
        $course = Course::with('program.lessons', 'students', 'students.submissions', 'teachers', 'program.steps', 'program.lessons.prerequisites', 'program.lessons.info')->findOrFail($id);
        $students = $course->students;

        if (!$course->is_sdl) {
            $marks = CompletedCourse::where('course_id', $id)->get();

            if ($request->has('chapter')) {
                $chapter = ProgramChapter::findOrFail($request->chapter);
            } else {
                if ($user->role == 'teacher') {
                    $chapter = $course->program->chapters->first();
                } else {
                    $current_chapter = $course->program->chapters->first();
                    foreach ($course->program->chapters as $chapter) {
                        $current_chapter = $chapter;
                        if (!$chapter->isDone($course)) {
                            break;
                        }
                    }
                    $chapter = $current_chapter;
                }
            }


            $temp_steps = collect([]);
            $all_steps = collect([]);
            $lessons = $course->lessons->filter(function ($lesson) use ($course, $chapter) {
                return $lesson->isStarted($course) and $lesson->chapter_id == $chapter->id;
            });


            foreach ($lessons as $lesson) {
                $temp_steps = $temp_steps->merge($lesson->steps);
            }
            foreach ($course->lessons->filter(function ($item) use ($course) {
                return $item->isStarted($course);
            }) as $lesson) {
                $all_steps = $all_steps->merge($lesson->steps);
            }

            if ($course->state == 'started') {
                /* count pulse */

                $ids = $students->map(function ($item, $key) {
                    return $item->id;
                })->values();

                $steps_ids = $temp_steps->map(function ($item, $key) {
                    return $item->id;
                })->values();

                $records = ActionLog::where('created_at', '>', Carbon::now()->addWeeks(-2))->whereIn('user_id', $ids)->get()->filter(function ($item) use ($steps_ids, $course) {
                    return ($item->type == 'course' and $item->object_id == $course->id) or ($item->type == 'step' and $steps_ids->contains($item->object_id));
                })->groupBy(function ($item) {
                    return $item->created_at->format('Y-m-d H:00:00');
                })->map(function ($item) {
                    return $item->count();
                });

                if ($records->count() != 0) {
                    $first_hour = Carbon::createFromFormat('Y-m-d H:00:00', $records->keys()[0]);

                    while ($first_hour->lt(Carbon::now())) {
                        $first_hour->addHour();
                        if (!$records->has($first_hour->format('Y-m-d H:00:00'))) {
                            $records[$first_hour->format('Y-m-d H:00:00')] = 0;
                        }
                    }

                    $records = $records->sortBy(function ($item, $key) {
                        return Carbon::createFromFormat('Y-m-d H:00:00', $key);
                    });

                    $pulse_keys = '[\'' . implode('\', \'', $records->keys()->toArray()) . '\']';
                    $pulse_values = '[\'' . implode('\', \'', $records->values()->toArray()) . '\']';
                } else {
                    $pulse_keys = '[]';
                    $pulse_values = '[]';
                }


            } else {
                $pulse_keys = '[]';
                $pulse_values = '[]';
            }


            foreach ($students as $key => $value) {
                $students[$key]->percent = 0;
                $students[$key]->max_points = 0;
                $students[$key]->points = 0;
                foreach ($all_steps as $step) {
                    if ($value->pivot->is_remote) {
                        $tasks = $step->remote_tasks;
                    } else {
                        $tasks = $step->class_tasks;
                    }

                    foreach ($tasks as $task) {
                        if (!$task->is_star) $students[$key]->max_points += $task->max_mark;
                        $students[$key]->points += $value->submissions->where('task_id', $task->id)->max('mark');
                    }


                }
                if ($students[$key]->max_points != 0) {
                    $students[$key]->percent = min(100, $students[$key]->points * 100 / $students[$key]->max_points);
                }
            }


            if ($user->role == 'student') {
                $lessons = $course->lessons->filter(function ($lesson) use ($course, $chapter) {
                    return $lesson->isStarted($course) and $lesson->chapter_id == $chapter->id;
                });

                $steps = $temp_steps;
                $cstudent = $students->filter(function ($value, $key) use ($user) {
                    return $value->id == $user->id;
                })->first();
            } else {
                $steps = $temp_steps;
                $lessons = $course->lessons->where('chapter_id', $chapter->id);
            }


            return view('courses.details', compact('chapter', 'course', 'user', 'steps', 'students', 'cstudent', 'lessons', 'marks', 'pulse_keys', 'pulse_values'));

        } else {
            $marks = [];
            $lessons = $course->user_sdl_lessons($user)->get();
            //$available_lessons = Lesson::where('sdl_node_id', '!=', null)->where('is_sdl', true)->get();
            $available_lessons = Lesson::getAvailableSdlLessons($user, $course);
            return view('courses.sdl_details', compact('course', 'user', 'lessons', 'marks', 'students', 'available_lessons'));
        }


    }

    public function addSdlLesson($id, Request $request)
    {
        $user = User::findOrFail(Auth::User()->id);
        $course = Course::findOrFail($id);
        $lesson = Lesson::findOrFail($request->lesson_id);

        if (!$course->is_sdl) abort(422);
        if ($lesson->sdl_node_id == null) abort(422);
        if (!$course->students->contains($user) and !$course->teachers->contains($user)) {
            abort(422);
        }

        $course->sdl_lessons()->attach($request->lesson_id, array('user_id' => $user->id));
        return redirect('/insider/courses/' . $course->id);

    }

    public function assessments($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.assessments', compact('course'));
    }

    public function createView()
    {
        $programs = Program::all();
        return view('courses.create', compact('programs'));
    }

    public function editView($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.edit', compact('course'));
    }

    public function start($id)
    {
        $course = Course::findOrFail($id);
        $course->start();
        return redirect('/insider/courses/' . $course->id);
    }

    public function stop($id)
    {
        $course = Course::findOrFail($id);
        $course->end();
        return redirect('/insider/courses/' . $course->id);
    }

    public function createChapterView($course_id)
    {
        return view('courses.create_chapter');
    }

    public function editChapterView($course_id, $chapter_id)
    {
        $chapter = ProgramChapter::findOrFail($chapter_id);
        return view('courses.edit_chapter', compact('chapter'));
    }

    public function editChapter($course_id, $chapter_id, Request $request)
    {
        $user = User::findOrFail(Auth::User()->id);
        $chapter = ProgramChapter::findOrFail($chapter_id);


        $this->validate($request, [
            'name' => 'required|string',

        ]);

        $chapter = ProgramChapter::findOrFail($chapter_id);
        $chapter->name = $request->name;
        $chapter->description = $request->description;
        $chapter->save();

        return redirect('/insider/courses/' . $course_id . '?chapter=' . $chapter_id);
    }

    public function createChapter($course_id, Request $request)
    {
        $user = User::findOrFail(Auth::User()->id);


        $this->validate($request, [
            'name' => 'required|string'
        ]);

        $course = Course::findOrFail($course_id);
        $program = $course->program;

        $order = 100;
        if ($program->chapters->count() != 0)
            $order = $program->chapters->last()->sort_index + 1;

        $chapter = new ProgramChapter();
        $chapter->name = $request->name;
        $chapter->program_id = $program->id;
        $chapter->sort_index = $order;
        $chapter->description = $request->description;

        $chapter->save();

        return redirect('/insider/courses/' . $course_id);
    }

    public function makeChapterLower($course_id, $chapter_id, Request $request)
    {
        $chapter = ProgramChapter::findOrFail($chapter_id);
        $chapter->sort_index -= 1;
        $chapter->save();
        return redirect('/insider/courses/' . $course_id . '?chapter=' . $chapter_id);
    }

    public function makeChapterUpper($course_id, $chapter_id, Request $request)
    {
        $chapter = ProgramChapter::findOrFail($chapter_id);
        $chapter->sort_index += 1;
        $chapter->save();
        return redirect('/insider/courses/' . $course_id . '?chapter=' . $chapter_id);
    }

    public function edit($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $course = Course::findOrFail($id);
        $course->name = $request->name;
        $course->description = $request->description;
        $course->git = $request->git;
        $course->site = $request->site;
        $course->image = $request->image;
        $course->telegram = $request->telegram;

        foreach ($course->teachers as $teacher) {
            $course->teachers()->detach($teacher->id);
        }
        if ($request->teachers != null)
            foreach ($request->teachers as $teacher_id) {
                $course->teachers()->attach($teacher_id);
            }

        foreach ($course->students as $teacher) {
            $course->students()->detach($teacher->id);
        }
        if ($request->students != null)
            foreach ($request->students as $teacher_id) {
                $course->students()->attach($teacher_id);
            }


        if ($course->invite != $request->invite) {
            $this->validate($request, [
                'invite' => 'required|string|unique:courses,invite|unique:providers,invite',
            ]);
            $course->invite = $request->invite;
            $course->remote_invite = $request->invite . '-R';
        }


        /*if ($request->hasFile('image')) {
            $extn = '.' . $request->file('image')->guessClientExtension();
            $path = $request->file('image')->storeAs('course_avatars', $course->id . $extn);
            $course->image = $path;

        }*/
        if ($request->hasFile('import')) {
            $json = file_get_contents($request->file('import')->getRealPath());

            $course->import($json);
        }

        $course->save();
        return redirect('/insider/courses/' . $course->id);
    }

    public function create(Request $request)
    {
        $user = User::findOrFail(Auth::User()->id);


        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|max:1000',
        ]);

        $course = new Course();
        if ($request->program >= 0) {
            $this->validate($request, ['program' => 'required|integer|exists:programs,id']);
            $course->program_id = $request->program;
        } else {
            if ($request->program == -1) {
                $program = new Program();
                $program->name = $request->name;
                $program->save();

                $course->program_id = $program->id;

                $order = 100;
                if ($program->chapters->count() != 0)
                    $order = $program->chapters->last()->sort_index + 1;

                $chapter = new ProgramChapter();
                $chapter->name = $request->name;
                $chapter->program_id = $program->id;
                $chapter->sort_index = $order;
                $chapter->description = $request->description;

                $chapter->save();
            } else if ($request->program == -2) {
                $this->validate($request, ['sdl_version' => 'required|integer|exists:core_nodes,version']);
                $course->is_sdl = true;
                $course->sdl_core_version = $request->sdl_version;
                $course->program_id = null;
            } else {
                abort(422);
            }

        }


        $course->name = $request->name;
        $course->description = $request->description;
        $course->save();
        $course->teachers()->attach($user->id);


        if ($request->hasFile('image')) {
            $extn = '.' . $request->file('image')->guessClientExtension();
            $path = $request->file('image')->storeAs('course_avatars', $course->id . $extn);
            $course->image = $path;

        } else {
            $course->image = 'course_avatars/blank.png';
        }
        $course->provider_id = $user->provider_id;
        $course->save();


        return redirect('/insider/courses');
    }


    public function invite(Request $request)
    {
        if ($request->invite == null || $request->invite == "") {
            $this->make_error_alert('Ошибка!', 'Курс с таким приглашением не найден.');
            return $this->backException();
        }
        $user = User::findOrFail(Auth::User()->id);
        $course = Course::where('invite', $request->invite)->first();
        $remote = false;
        if ($course == null) {
            $course = Course::where('remote_invite', $request->invite)->first();
            $remote = true;
        }

        if ($course == null) {
            $this->make_error_alert('Ошибка!', 'Курс с таким приглашением не найден.');
            return $this->backException();
        }

        if ($course->students->contains($user)) {
            $this->make_error_alert('Ошибка!', 'Вы уже зачислены на курс "' . $course->name . '".');
            return $this->backException();
        }
        $this->make_success_alert('Успех!', 'Вы присоединились к курсу "' . $course->name . '".');
        $course->students()->attach([$user->id => ['is_remote' => $remote]]);


        return redirect()->back();
    }

    public function export($id)
    {
        $course = Course::findOrFail($id);

        $json = $course->export();

        $response = \Response::make($json);
        $response->header('Content-Type', 'application/json');
        $response->header('Content-length', strlen($json));
        $response->header('Content-Disposition', 'attachment; filename=course-' . $id . '.json');

        return $response;

    }
}
