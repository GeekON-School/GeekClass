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
    return redirect('/courses');
});

Auth::routes();

Route::get('/courses', 'CoursesController@index')->name('Courses');

Route::get('/courses/create', 'CoursesController@createView')->name('Create course');
Route::post('/courses/create', 'CoursesController@create');

Route::get('/courses/{id}/', 'CoursesController@details');
Route::get('/courses/{id}/edit', 'CoursesController@editView');
Route::post('/courses/{id}/edit', 'CoursesController@edit');

Route::get('/courses/{id}/create', 'StepsController@createView');
Route::post('/courses/{id}/create', 'StepsController@create');

Route::get('/lessons/{id}', 'StepsController@details');
Route::get('/lessons/{id}/edit', 'StepsController@editView');
Route::post('/lessons/{id}/edit', 'StepsController@edit');



Route::get('media/{dir}/{name}', 'MediaController@index');
