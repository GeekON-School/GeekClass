<?php
/**
 * Created by PhpStorm.
 * User: AlexNerru
 * Date: 03.09.2017
 * Time: 23:22
 */

namespace App\Http\Controllers;

use App\CoinTransaction;
use App\Idea;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;


class IdeasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('idea')->except(['index', 'details', 'createView', 'create']);
    }

    public function index()
    {
        $user = User::findOrFail(Auth::User()->id);
        $ideas = Idea::all();
        $ideas = $ideas->groupBy(function ($item, $key) {
            return mb_substr($item->name, 0, 1);     //treats the name string as an array
        })->sortBy(function ($item, $key) {      //sorts A-Z at the top level
            return $key;
        });
        return view('ideas.index', compact('ideas', 'user'));
    }

    public function details($id)
    {
        $user = User::findOrFail(Auth::User()->id);
        $idea = Idea::findOrFail($id);
        $author = $idea->author();
        return view('ideas.details', compact('idea', 'user', 'author'));
    }

    public function createView()
    {
        return view('ideas.create');
    }

    public function editView($id)
    {
        $idea = Idea::findOrFail($id);
        return view('ideas.edit', compact('idea'));
    }

    public function edit($id, Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string',
            'short_description' => 'nullable|string',
            'description' => 'required|string',
        ]);


        $idea = Idea::findOrFail($id);
        $idea->name = $request->name;
        $idea->description = clean($request->description);
        $idea->short_description = clean($request->short_description);
        $idea->save();


        return redirect('/insider/ideas/' . $idea->id);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'short_description' => 'nullable|string',
            'description' => 'required|string',
            'g-recaptcha-response' => 'required|captcha'

        ]);
        $user = User::findOrFail(Auth::User()->id);
        $idea = new Idea();
        $idea->name = $request->name;
        $idea->description = clean($request->description);
        $idea->short_description = clean($request->short_description);
        $idea->author_id = $user->id;
        $idea->save();

        CoinTransaction::register(Auth::User()->id, 3, "Idea #" . $idea->id);

        return redirect('/insider/ideas/' . $idea->id);
    }

    public function delete($id)
    {
        $idea = Idea::findOrFail($id);
        $idea->delete();
        return redirect('/insider/ideas/');
    }
}