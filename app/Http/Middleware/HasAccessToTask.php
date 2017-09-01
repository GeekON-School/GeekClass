<?php

namespace App\Http\Middleware;

use App\Course;
use App\CourseStep;
use App\Task;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class HasAccessToTask
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::User()->role=='teacher') {
            return $next($request);
        }

        if (Auth::User()->role=='student') {

            $user = User::findOrFail(Auth::User()->id);
            $task = Task::findOrFail($request->id);
            if ($task->step->course->students->contains($user))
            {
                return $next($request);
            }
        }

        return abort(403);

    }
}
