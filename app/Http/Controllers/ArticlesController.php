<?php
/**
 * Created by PhpStorm.
 * User: AlexNerru
 * Date: 03.09.2017
 * Time: 23:22
 */

namespace App\Http\Controllers;

use App\Article;
use App\CoinTransaction;
use App\ForumComment;
use App\ForumPost;
use App\ForumTag;
use App\ForumThread;
use App\ForumVote;
use App\Notifications\NewForumAnswer;
use App\Project;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;


class ArticlesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index', 'details');
        $this->middleware('teacher')->except('index', 'details');
    }

    public function index(Request $request)
    {
        $tag = null;
        if ($request->has('tag') and $request->tag != "") {
            $tag = ForumTag::where('name', $request->tag)->first();
        }

        $articles = Article::orderBy('created_at', 'DESC')->get();

        if ($tag) {
            $articles = $articles->filter(function ($item) use ($tag) {
                return $item->tags->contains($tag);
            });
        }

        return view('articles.index', compact('articles', 'tag'));
    }

    public function createView()
    {
        return view('articles.create');
    }

    public function editView($id)
    {
        $article = Article::findOrFail($id);
        $user = User::findOrFail(Auth::User()->id);

        if ($article->author_id != $user->id and $user->role != 'admin') abort(503);

        return view('article.edit', compact('article'));
    }

    public function edit($id, Request $request)
    {
        $article = Article::findOrFail($id);
        $user = User::findOrFail(Auth::User()->id);

        if ($article->author_id != $user->id and $user->role != 'admin') abort(503);


        $this->validate($request, [
            'name' => 'required|string',
            'text' => 'required|string',
            'anounce' => 'required|string',
            'tags' => 'required|string'
        ]);

        $article->text = clean($request->text);
        $article->anounce = clean($request->anounce);
        $article->name = $request->name;

        foreach ($article->tags as $tag) {
            $article->tags()->detach($tag->id);
        }
        $parts = explode(';', $request->tags);
        foreach ($parts as $tag) {
            if ($tag == '') continue;
            $article->attachTag($tag);
        }
        $article->save();

        return redirect('/articles/' . $id);

    }


    public function create(Request $request)
    {
        $user = User::findOrFail(Auth::User()->id);

        $this->validate($request, [
            'name' => 'required|string',
            'text' => 'required|string',
            'anounce' => 'required|string',
            'tags' => 'required|string'

        ]);
        $user = User::findOrFail(Auth::User()->id);

        $article = new Article();
        $article->text = clean($request->text);
        $article->anounce = clean($request->anounce);
        $article->name = $request->name;
        $article->author_id = $user->id;
        $article->save();

        $parts = explode(';', $request->tags);

        foreach ($parts as $tag) {
            if ($tag == '') continue;
            $article->attachTag($tag);
        }

        return redirect('/articles');
    }

    public function delete($id, Request $request)
    {
        $article = Article::findOrFail($id);
        $user = User::findOrFail(Auth::User()->id);

        if ($article->user_id != $user->id and $user->role != 'admin') abort(503);
        $article->delete();

        return redirect('/articles');
    }


    public function details($id)
    {
        $article = Article::findOrFail($id);
        $article->visits += 1;
        $article->save();
        return view('articles.details', compact('article'));
    }


}
