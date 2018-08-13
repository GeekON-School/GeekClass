<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/home', function () {
    if (\Illuminate\Support\Facades\Auth::check() ) {
        return redirect('/insider');
    }
    return redirect('/login');

});

Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check() ) {
        return redirect('/insider');
    }
    return redirect('/login');

});

Auth::routes();

Route::prefix('open')->group(function () {
    Route::get('/steps/{id}', 'OpenStepsController@details');
});

Route::prefix('insider')->middleware(['auth'])->group(function () {

    #TODO Check
    Route::get('/', function () {
        return redirect('/insider/courses');
    });
    Route::get('/courses', 'CoursesController@index')->name('Courses');

    Route::get('/courses/create', 'CoursesController@createView')->name('Create course');
    Route::post('/courses/create', 'CoursesController@create');

    Route::get('/courses/{id}/', 'CoursesController@details');
    Route::get('/courses/{id}/edit', 'CoursesController@editView');
    Route::get('/courses/{id}/start', 'CoursesController@start');
    Route::get('/courses/{id}/stop', 'CoursesController@stop');
    Route::post('/courses/{id}/edit', 'CoursesController@edit');
    Route::get('/courses/{id}/assessments', 'CoursesController@assessments');
    Route::get('/courses/{id}/export', 'CoursesController@export');


    Route::get('/programs', 'ProgramsController@index');
    Route::get('/programs/create', 'ProgramsController@createView')->name('Create program');
    Route::post('/programs/create', 'ProgramsController@create');
    Route::get('/programs/{id}/', 'ProgramsController@details');
    Route::get('/programs/{id}/edit', 'ProgramsController@editView');
    Route::post('/programs/{id}/edit', 'ProgramsController@edit');
    Route::get('/courses/{id}/create', 'LessonsController@createView');
    Route::post('/courses/{id}/create', 'LessonsController@create');


    Route::get('/courses/{course_id}/lessons/{id}/edit', 'LessonsController@editView');
    Route::post('/courses/{course_id}/lessons/{id}/edit', 'LessonsController@edit');
    Route::get('/courses/{course_id}/lessons/{id}/export', 'LessonsController@export');
    Route::get('/courses/{course_id}/lessons/{id}/lower', 'LessonsController@makeLower');
    Route::get('/courses/{course_id}/lessons/{id}/upper', 'LessonsController@makeUpper');
    Route::get('/courses/{course_id}/lessons/{id}/delete', 'LessonsController@delete');


    Route::get('/courses/{course_id}/lessons/{id}/create', 'StepsController@createView');
    Route::post('/courses/{course_id}/lessons/{id}/create', 'StepsController@create');
    Route::get('/courses/{course_id}/steps/{id}', 'StepsController@details');
    Route::get('/courses/{course_id}/perform/{id}', 'StepsController@perform');
    Route::get('/courses/{course_id}/steps/{id}/edit', 'StepsController@editView');
    Route::get('/courses/{course_id}/steps/{id}/lower', 'StepsController@makeLower');
    Route::get('/courses/{course_id}/steps/{id}/upper', 'StepsController@makeUpper');
    Route::get('/courses/{course_id}/steps/{id}/delete', 'StepsController@delete');
    Route::post('/courses/{course_id}/steps/{id}/edit', 'StepsController@edit');
    Route::post('/courses/{course_id}/steps/{id}/question', 'StepsController@question');
    Route::post('/courses/{course_id}/steps/{id}/task', 'TasksController@create');

    Route::get('/courses/{course_id}/questions/{id}/delete', 'StepsController@deleteQuestion');
    Route::get('/courses/{course_id}/tasks/{id}/delete', 'TasksController@delete');
    Route::get('/courses/{course_id}/tasks/{id}/edit', 'TasksController@editForm');

    Route::get('/courses/{course_id}/tasks/{id}/up', 'TasksController@toPreviousTask');
    Route::get('/courses/{course_id}/tasks/{id}/down', 'TasksController@toNextTask');
    Route::get('/courses/{course_id}/tasks/{id}/left', 'TasksController@makeLower');
    Route::get('/courses/{course_id}/tasks/{id}/right', 'TasksController@makeUpper');
    Route::get('/courses/{course_id}/tasks/{id}/peer', 'TasksController@reviewTable');

    Route::post('/courses/{course_id}/tasks/{id}/edit', 'TasksController@edit');
    Route::post('/courses/{course_id}/tasks/{id}/solution', 'TasksController@postSolution');
    Route::get('/courses/{course_id}/tasks/{id}/phantom', 'TasksController@phantomSolution');
    Route::get('/courses/{course_id}/tasks/{id}/student/{student_id}', 'TasksController@reviewSolutions');
    Route::post('/courses/{course_id}/solution/{id}', 'TasksController@estimateSolution');
    Route::get('/invite', 'CoursesController@invite');

    Route::get('/community', 'ProfileController@index');
    Route::get('/profile/{id?}', 'ProfileController@details');


    Route::get('/profile/{id}/edit', 'ProfileController@editView');
    Route::post('/profile/{id}/edit', 'ProfileController@edit');
    Route::post('/profile/{id}/course', 'ProfileController@course');
    Route::get('/profile/delete-course/{id}', 'ProfileController@deleteCourse');

    Route::get('/projects/create', 'ProjectsController@createView');
    Route::post('/projects/create', 'ProjectsController@create');
    Route::get('/projects/{id}', 'ProjectsController@details');
    Route::post('/project/{id}/edit', 'ProjectsController@edit');

    Route::get('/projects/{id}/edit', 'ProjectsController@editView');
    Route::post('/projects/{id}/edit', 'ProjectsController@edit');
    Route::get('/projects/{id}/delete', 'ProjectsController@deleteProject');
    Route::get('/projects', 'ProjectsController@index');

    Route::get('/events', 'EventController@event_view');
    Route::get('/events/old', 'EventController@old_events_view');
    Route::get('/events/add_event', 'EventController@add_event_view');
    Route::post('/events/add_event', 'EventController@add_event');
    Route::get('/events/{id}', 'EventController@current_event');
    Route::get('/events/{id}/go', 'EventController@go_event');
    Route::get('/events/{id}/left', 'EventController@left_event');
    Route::get('/events/{id}/like', 'EventController@like_event');
    Route::get('/events/{id}/like_from_events', 'EventController@like_event_from_events');
    Route::get('/events/{id}/dislike', 'EventController@dislike_event');
    Route::get('/events/{id}/dislike_from_events', 'EventController@dislike_event_from_events');
    Route::get('/events/{id}/add_org', 'EventController@add_org');
    Route::post('/events', 'EventController@event_view');
    Route::post('/events/old', 'EventController@old_events_view');
    Route::get('/events/{id}/edit', 'EventController@edit_event_view');
    Route::post('/events/{id}/edit', 'EventController@edit_event');
    Route::get('/events/{id}/delete', 'EventController@del_event');
    Route::get('/events/{id}/delete_comm/{id2}', 'EventController@del_comment');

    Route::post('/events/{id}', 'EventController@add_comment');

    Route::get('/core/{id}', 'CoreController@index');
    Route::get('/core/network/{id}', 'CoreController@get_core');
    Route::get('/core/import', 'CoreController@import_core_form');
    Route::post('/core/import', 'CoreController@import_core');


    Route::get('/testmail', function () {
        $user = \App\User::findOrFail(1);
        $when = \Carbon\Carbon::now()->addSeconds(1);
        $user->notify((new \App\Notifications\NewSolution())->delay($when));
    });

    Route::get('/migrate_to_lessons', function () {
        $courses = \App\Course::all();
        foreach ($courses as $course)
        {
            foreach ($course->steps as $step)
            {
                $lesson = new \App\Lesson();
                $lesson->name = $step->name;
                $lesson->start_date = $step->start_date;
                $lesson->description = $step->description;
                $lesson->course_id = $step->course_id;
                $lesson->save();

                $step->lesson_id = $lesson->id;
                $step->save();
            }
        }

    });

    Route::get('/migrate_to_programs', function () {
        $courses = \App\Course::all();
        foreach ($courses as $course)
        {
            $program = new \App\Program();
            $program->name = $course->name;
            $program->save();
            $program->authors()->attach(1);

            $course->program_id = $program->id;
            $course->save();

            \DB::table('lessons')->where('course_id', $course->id)->update(['program_id'=> $program->id]);
            foreach ($course->lessons as $lesson)
            {
                $lesson->program_id = $program->id;
                foreach ($lesson->steps as $step)
                {
                    $step->program_id = $program->id;
                    $step->save();
                }
                $lesson->save();

                foreach ($step->tasks as $task)
                {
                    \DB::table('solutions')->where('task_id', $task->id)->update(['course_id'=> $course->id]);
                }
            }
        }

    });

    Route::get('/clean_empty_programs', function () {
        $programs = \App\Program::all();
        foreach ($programs as $program)
        {
            if (count($program->courses) == 0)
            {
                $program->delete();
            }
        }

    });

    Route::get('/open_all_lessons', function () {
        $courses = \App\Course::all();
        foreach ($courses as $course)
        {
            foreach ($course->lessons as $lesson)
            {
                $lesson->setStartDate($course, '2016-01-01');
            }

        }
        echo 'ok';

    });

    Route::get('/set_solution_courses', function () {
        $solutions = \App\Solution::where('course_id', null)->get();
        foreach ($solutions as $solution)
        {
            $course = \App\Course::where('program_id', $solution->task->step->program_id)->first();
            $solution->course_id = $course->id;
            $solution->save();
        }

    });

});


Route::get('media/{dir}/{name}', 'MediaController@index');
