<?php

namespace App\Http\Middleware;

use App\Course;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class HasAccessToCourse
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
            $course = Course::findOrFail($request->id);
            if ($course->students->contains($user))
            {
                return $next($request);
            }
        }

        return abort(403);

    }
}
