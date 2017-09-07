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
        $this->middleware('self')->only(['createProject, editProject']);
    }

    public function index()
    {
        $user  = User::findOrFail(Auth::User()->id);
        $projects = Project::all();
        return view('home', compact('projects', 'user'));
    }

    #TODO change it
    public function details($id)
    {
        $user  = User::findOrFail(Auth::User()->id);
        $project = Project::findOrFail($id);
        return view('projects.details', compact('project', 'user'));
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
            'description' => 'required|string',
            'type' => 'required|string',
            'url' => 'required|string',
        ]);

        $project = Project::findOrFail($id);
        $project->name = $request->name;
        $project->description = $request->description;
        $project->type = $request->type;
        $project->url = $request->url;

        $project->save();
        #TODO Change it
        return redirect()->back();
    }
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string'
        ]);
        $user  = User::findOrFail(Auth::User()->id);
        $project = Project::createProject($request);
        $project->save();
        $project->students()->attach($user->id);
        #TODO Change it
        return redirect()->back();
    }
}