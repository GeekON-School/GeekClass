<?php
/**
 * Created by PhpStorm.
 * User: AlexNerru
 * Date: 03.09.2017
 * Time: 23:22
 */

namespace App\Http\Controllers;

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


class ForumController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = User::findOrFail(Auth::User()->id);
        $q = "";
        $tag = null;
        if ($request->has('tag') and $request->tag != "") {
            $tag = ForumTag::where('name', $request->tag)->first();
        }
        if ($request->has('q') and $request->q != "") {
            $q = mb_strtolower($request->q);
            $threads = ForumThread::whereRaw('LOWER(name)', 'LIKE', '%' . $request->q . '%')->orderBy('created_at', 'DESC')->get();
            $posts = ForumPost::where('LOWER(text)', 'LIKE', '%' . $request->q . '%')->with('thread')->orderBy('created_at', 'DESC')->get();
            foreach ($posts as $post) {
                if (!$threads->contains($post->thread)) {
                    $threads->push($post->thread);
                }
            }
        } else {
            $threads = ForumThread::orderBy('created_at', 'DESC')->get();
        }

        if ($tag) {
            $threads = $threads->filter(function ($item) use ($tag) {
                return $item->tags->contains($tag);
            });
        }

        return view('forum.index', compact('user', 'threads', 'q', 'tag'));
    }

    public function createView()
    {
        return view('forum.create');
    }

    public function editView($thread_id, $id)
    {
        $post = ForumPost::findOrFail($id);
        $thread = ForumThread::findOrFail($thread_id);
        $user = User::findOrFail(Auth::User()->id);

        if ($post->user_id != $user->id and $user->role != 'teacher') abort(503);

        return view('forum.edit', compact('post', 'thread'));
    }

    public function edit($thread_id, $id, Request $request)
    {
        $post = ForumPost::findOrFail($id);
        $thread = ForumThread::findOrFail($thread_id);
        $user = User::findOrFail(Auth::User()->id);

        if ($post->is_question) {
            $this->validate($request, [
                'name' => 'required|string',
                'text' => 'required|string'

            ]);
        } else {
            $this->validate($request, [
                'text' => 'required|string'
            ]);
        }

        if ($post->user_id != $user->id and $user->role != 'teacher') abort(503);

        $post->text = $request->text;
        $post->save();

        $thread->name = $request->name;
        $thread->save();

        return redirect('/insider/forum/' . $thread_id);
    }

    public function createThread(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'text' => 'required|string',
            'tags' => 'required|string'

        ]);
        $user = User::findOrFail(Auth::User()->id);

        $thread = new ForumThread();
        $thread->name = $request->name;
        $thread->user_id = $user->id;
        $thread->save();

        $parts = explode(';', $request->tags);

        foreach ($parts as $tag) {
            if ($tag == '') continue;
            $thread->attachTag($tag);
        }

        $post = new ForumPost();
        $post->text = $request->text;
        $post->thread_id = $thread->id;
        $post->user_id = $user->id;
        $post->save();

        return redirect('/insider/forum');
    }

    public function answer($id, Request $request)
    {
        $this->validate($request, [
            'text' => 'required|string'

        ]);
        $thread = ForumThread::findOrFail($id);
        $user = User::findOrFail(Auth::User()->id);


        $post = new ForumPost();
        $post->text = $request->text;
        $post->thread_id = $thread->id;
        $post->user_id = $user->id;
        $post->is_question = false;
        $post->save();

        $when = Carbon::now()->addSeconds(1);

        $thread->user->notify((new NewForumAnswer($post))->delay($when));

        return redirect('/insider/forum/' . $id);
    }

    public function delete($thread_id, $id, Request $request)
    {
        $post = ForumPost::findOrFail($id);
        $user = User::findOrFail(Auth::User()->id);

        if ($post->user_id != $user->id and $user->role != 'teacher') abort(503);
        $post->delete();

        return redirect('/insider/forum/' . $thread_id);
    }

    public function upvote($thread_id, $id, Request $request)
    {
        $post = ForumPost::findOrFail($id);
        $user = User::findOrFail(Auth::User()->id);

        if ($post->user_id == $user->id) abort(503);
        $vote = new ForumVote();
        $vote->user_id = $user->id;
        $vote->mark = 1;
        $vote->post_id = $id;
        $vote->save();

        if ($post->getVotes() == 3 and $post->coin_delivered == false) {
            CoinTransaction::register($post->user->id, 3, 'QA #' . $post->id);
            $post->coin_delivered = true;
            $post->save();
        }

        return redirect('/insider/forum/' . $thread_id);
    }

    public function downvote($thread_id, $id, Request $request)
    {
        $post = ForumPost::findOrFail($id);
        $user = User::findOrFail(Auth::User()->id);

        if ($post->user_id == $user->id) abort(503);
        $vote = new ForumVote();
        $vote->user_id = $user->id;
        $vote->mark = -1;
        $vote->post_id = $id;
        $vote->save();

        return redirect('/insider/forum/' . $thread_id);
    }

    public function comment($thread_id, $id, Request $request)
    {
        $this->validate($request, [
            'text' => 'required|string'
        ]);
        $post = ForumPost::findOrFail($id);
        $user = User::findOrFail(Auth::User()->id);


        $comment = new ForumComment();
        $comment->text = $request->text;
        $comment->post_id = $post->id;
        $comment->user_id = $user->id;
        $comment->save();

        return redirect('/insider/forum/' . $thread_id);
    }

    public function details($id)
    {
        $thread = ForumThread::findOrFail($id);
        $thread->visits += 1;
        $thread->save();
        $user = User::findOrFail(Auth::User()->id);
        return view('forum.details', compact('thread', 'user'));
    }


}