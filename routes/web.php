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


Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::User()->role == 'teacher') {
        return redirect('/teacher');
    }
    if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::User()->role == 'student') {
        return redirect('/student');
    }
    return redirect('/login');

});

Auth::routes();

Route::prefix('teacher')->middleware(['auth', 'teacher'])->group(function () {

    Route::get('/', function () {
        return redirect('/teacher/courses');
    });
    Route::get('/courses', 'Teacher\CoursesController@index')->name('Courses');

    Route::get('/courses/create', 'Teacher\CoursesController@createView')->name('Create course');
    Route::post('/courses/create', 'Teacher\CoursesController@create');

    Route::get('/courses/{id}/', 'Teacher\CoursesController@details');
    Route::get('/courses/{id}/edit', 'Teacher\CoursesController@editView');
    Route::get('/courses/{id}/start', 'Teacher\CoursesController@start');
    Route::get('/courses/{id}/stop', 'Teacher\CoursesController@stop');
    Route::post('/courses/{id}/edit', 'Teacher\CoursesController@edit');

    Route::get('/courses/{id}/create', 'Teacher\StepsController@createView');
    Route::post('/courses/{id}/create', 'Teacher\StepsController@create');

    Route::get('/lessons/{id}', 'Teacher\StepsController@details');
    Route::get('/lessons/{id}/edit', 'Teacher\StepsController@editView');
    Route::post('/lessons/{id}/edit', 'Teacher\StepsController@edit');
    Route::post('/lessons/{id}/question', 'Teacher\StepsController@question');
    Route::post('/lessons/{id}/task', 'Teacher\StepsController@task');

    Route::get('/questions/{id}/delete', 'Teacher\StepsController@deleteQuestion');
    Route::get('/tasks/{id}/delete', 'Teacher\StepsController@deleteTask');
});

Route::prefix('student')->middleware(['auth', 'student'])->group(function () {
    Route::get('/courses', 'Student\CoursesController@index');
    Route::get('/invite', 'Student\CoursesController@invite');
    Route::get('/courses/{id}/', 'Student\CoursesController@details');

    Route::get('/', function () {
        return redirect('/student/courses');
    });
});

Route::get('media/{dir}/{name}', 'MediaController@index');
