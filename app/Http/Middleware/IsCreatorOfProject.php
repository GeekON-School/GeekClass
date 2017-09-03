<?php
/**
 * Created by PhpStorm.
 * User: AlexNerru
 * Date: 03.09.2017
 * Time: 23:46
 */

namespace App\Http\Middleware;

use App\Project;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsCreatorOfProject
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::User()->role=='student') {

            $user = User::findOrFail(Auth::User()->id);
            $project = Project::findOrFail($request->id);
            if ($project->creatorsOfProject->contains($user))
            {
                return $next($request);
            }
        }
        return abort(403);
    }
}