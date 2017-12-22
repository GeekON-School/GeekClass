<?php
/**
 * Created by PhpStorm.
 * User: AlexNerru
 * Date: 03.09.2017
 * Time: 23:22
 */

namespace App\Http\Controllers;
use App\Project;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;


class ProjectsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('project')->only(['editView', 'editProject', 'delete']);
    }

    public function index()
    {
        $user  = User::findOrFail(Auth::User()->id);
        $projects = Project::all();
        return view('projects.index', compact('projects', 'user'));
    }

    public function details($id)
    {
        $user  = User::findOrFail(Auth::User()->id);
        $project = Project::findOrFail($id);
        $author = $project->author();
        $guest_projects = $user->projects;
        $is_in_project = false;
        $is_author = false;
        if ($author == $user->id )
            $is_author = true;
        $is_in_project = $project->Students->contains($user);
        $tags = explode(" ", $project->tags);
        return view('projects.details', compact('project', 'user', 'is_in_project', 'is_author', 'tags'));
    }
    public function createView()
    {
        return view('projects.create');
    }
    public function editView($id)
    {
        $project = Project::findOrFail($id);
        return view('projects.edit', compact('project', 'user'));
    }
    public function edit($id, Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string',
            'short_description' => 'required|string',
            'description' => 'nullable|string',
            'type' => 'nullable|string',
            'url' => 'nullable|string',
            'tags' => 'nullable|string',
            'image' => 'image|max:3000',
        ]);


        $project = Project::findOrFail($id);
        $project->editProject($request);


        return redirect('/insider/projects/'.$project->id);
    }
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'short_description' => 'required|string'

        ]);
        $user  = User::findOrFail(Auth::User()->id);
        $project = Project::createProject($request);
        $project->students()->attach($user->id);
        return redirect('/insider/projects/' . $project->id);
    }
    public function deleteProject($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect('/insider/profile/');
    }
}