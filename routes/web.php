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


    Route::get('/courses/{id}/create', 'LessonsController@createView');
    Route::post('/courses/{id}/create', 'LessonsController@create');
    Route::get('/lessons/{id}/edit', 'LessonsController@editView');
    Route::post('/lessons/{id}/edit', 'LessonsController@edit');
    Route::get('/lessons/{id}/export', 'LessonsController@export');
    Route::get('/lessons/{id}/lower', 'LessonsController@makeLower');
    Route::get('/lessons/{id}/upper', 'LessonsController@makeUpper');
    Route::get('/lessons/{id}/delete', 'LessonsController@delete');


    Route::get('/lessons/{id}/create', 'StepsController@createView');
    Route::post('/lessons/{id}/create', 'StepsController@create');
    Route::get('/steps/{id}', 'StepsController@details');
    Route::get('/perform/{id}', 'StepsController@perform');
    Route::get('/steps/{id}/edit', 'StepsController@editView');
    Route::get('/steps/{id}/lower', 'StepsController@makeLower');
    Route::get('/steps/{id}/upper', 'StepsController@makeUpper');
    Route::get('/steps/{id}/delete', 'StepsController@delete');
    Route::post('/steps/{id}/edit', 'StepsController@edit');
    Route::post('/steps/{id}/question', 'StepsController@question');
    Route::post('/steps/{id}/task', 'TasksController@create');

    Route::get('/questions/{id}/delete', 'StepsController@deleteQuestion');
    Route::get('/tasks/{id}/delete', 'TasksController@delete');
    Route::get('/tasks/{id}/edit', 'TasksController@editForm');

    Route::get('/tasks/{id}/up', 'TasksController@toPreviousTask');
    Route::get('/tasks/{id}/down', 'TasksController@toNextTask');
    Route::get('/tasks/{id}/left', 'TasksController@makeLower');
    Route::get('/tasks/{id}/right', 'TasksController@makeUpper');

    Route::post('/tasks/{id}/edit', 'TasksController@edit');
    Route::post('/tasks/{id}/solution', 'TasksController@postSolution');
    Route::get('/tasks/{id}/phantom', 'TasksController@phantomSolution');
    Route::get('/tasks/{id}/student/{student_id}', 'TasksController@reviewSolutions');
    Route::post('/solution/{id}', 'TasksController@estimateSolution');
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

});


Route::get('media/{dir}/{name}', 'MediaController@index');
