<?php

namespace App\Http\Middleware;

use App\Course;
use App\CourseStep;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class SelfAccess
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

            if (Auth::User()->id == $request->id)
            {
                return $next($request);
            }
        }
        return abort(403);

    }
}
