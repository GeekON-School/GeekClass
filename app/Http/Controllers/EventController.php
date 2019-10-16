<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Event;
use App\User;
use App\Tags;
use App\EventComments;

class EventController extends Controller
{
    public function current_event($id)
    {
        $event = Event::findOrFail($id);
        $user = User::all();
        $tags = Tags::all();
        $comments = EventComments::all();
        return view('/events/details', ['event' => $event, 'users' => $user, 'tags' => $tags, 'comments' => $comments]);
    }

    public function add_event_view()
    {
        $tags = Tags::all();
        return view('/events/add_event_view', ['tags' => $tags]);
    }

    public function event_view(Request $request)
    {
        $events = Event::getNew();
        $old_events = Event::getOld();
        $tags = Tags::all();
        $s_tags = [];
        if (isset($request->sel_tags)) {
            $s_tags = $request->sel_tags;
        } else {
            foreach ($tags as $tag) {
                array_push($s_tags, $tag->id);
            }
        }

        return view('/events/index', ['old_events' => $old_events, 'events' => $events, 'tags' => $tags, 's_tags' => $s_tags]);
    }

    public function old_events_view(Request $request)
    {
        $events = Event::getOld();
        $tags = Tags::all();
        $s_tags = [];
        if (isset($request->sel_tags)) {
            $s_tags = $request->sel_tags;
        } else {
            foreach ($tags as $tag) {
                array_push($s_tags, $tag->id);
            }
        }

        return view('/events/old_event_view', ['events' => $events, 'tags' => $tags, 's_tags' => $s_tags]);
    }

    public function add_event(Request $request)
    {
        $event = new Event;
        $event->name = $request->name;
        $event->text = clean($request->text);
        $event->date = $request->date;
        $event->location = $request->location;
        $event->type = $request->type;
        $event->short_text = $request->short_text;
        $event->max_people = $request->max_people;
        $event->skills = $request->skills;
        $event->site = $request->site;
        $event->save();
        $event->userOrgs()->attach(Auth::User()->id);
        if (isset($request->tags)) {
            $tags = $request->tags;
            foreach ($tags as $tag) {
                $event->tags()->attach($tag);
            }
        } else {
            $event->tags()->attach(1);
        }
        return redirect('/insider/events/' . $event->id);
    }

    public function del_event($id)
    {
        $event = Event::findOrFail($id);
        if (Auth::User()->role == 'admin' or Auth::User()->role == 'teacher' or $event->userOrgs->contains(Auth::User()->id)) {
            $event->delete();
        }
        return redirect('/insider/events');
    }

    public function go_event($id)

    {
        $event = Event::findOrFail($id);
        if ($event->participants()->where('id', Auth::User()->id)->count() == 0) {
            $event->participants()->attach(Auth::User()->id);
        }
        return redirect('/insider/events/' . $id);
    }

    public function left_event($id)
    {
        $event = Event::findOrFail($id);
        $event->participants()->detach(Auth::User()->id);
        return redirect('/insider/events/' . $id);
    }

    public function add_org(Request $request)
    {
        $event = Event::findOrFail($request->id);
        $users = User::all();
        if (!$event->isOwner(\Auth::id())) {
            return abort(403);
        }
        foreach ($users as $user) {
            if ($user->name == $request->name) {
                $event->userOrgs()->attach($user->id);
                break;
            }
        }
        return redirect('/insider/events/' . $event->id);
    }

    public function del_comment($id, $id2)
    {
        $comment = EventComments::findOrFail($id2);
        if ($comment->user_id == Auth::User()->id) {
            $comment->delete();
        }
        return redirect('/insider/events/' . $id);
    }

    public function like_event($id, Request $request)
    {
        $event = Event::findOrFail($id);

        // if ($event->user->id == \Auth::id()) abort(403);

        $event->vote(1);

        return redirect('/insider/events/' . $id);
    }

    public function dislike_event($id, Request $request)
    {
        $event = Event::findOrFail($id);

        // if ($event->user->id == \Auth::id()) abort(403);

        $event->vote(-1);

        return redirect('/insider/events/' . $id);
    }

    public function add_comment(Request $request, $id)
    {
        $comment = new EventComments;
        $comment->user_id = Auth::User()->id;
        $comment->event_id = $id;
        $comment->text = clean($request->text);
        $comment->save();
        return redirect('/insider/events/' . $comment->event_id);
    }

    public function edit_event_view($id)
    {
        $event = Event::findOrFail($id);
        if (Auth::User()->role == 'admin' or Auth::User()->role == 'teacher' or $event->userOrgs->contains(Auth::User()->id)) {
            $tags = Tags::all();
            return view('events/edit_event_view', ['event' => $event, 'tags' => $tags]);
        } else {
            return redirect('/insider/events/' . $id);
        }
    }

    public function edit_event(Request $request)
    {
        $event = Event::findOrFail($request->id);
        if (!(Auth::User()->role == 'admin' or Auth::User()->role == 'teacher' or $event->userOrgs->contains(Auth::User()->id)))
        {
            abort(503);
        }
        $event->name = $request->name;
        $event->text = clean($request->text);
        $event->date = $request->date;
        $time = explode(':', $request->time);
        $event->date = $event->date->setTime($time[0], $time[1]);
        $event->location = $request->location;
        $event->type = $request->type;
        $event->short_text = $request->short_text;
        $event->max_people = $request->max_people;
        $event->skills = $request->skills;
        $event->site = $request->site;
        $event->save();
        foreach ($event->userOrgs as $org) {
            $event->userOrgs()->detach($org->id);
        }
        $event->userOrgs()->attach(Auth::User()->id);
        if (isset($request->tags)) {
            $tags = $request->tags;
            foreach ($tags as $tag) {
                $event->tags()->attach($tag);
            }
        } else {
            $event->tags()->attach(1);
        }
        return redirect('/insider/events/' . $event->id);
    }
}
