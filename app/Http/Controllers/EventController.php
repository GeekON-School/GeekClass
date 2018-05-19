<?php

namespace App\Http\Controllers;

use App\EventComments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Event;
use App\User;
use App\EventTags;
use App\EventPartis;

class EventController extends Controller
{
    public function current_event($id)
    {
        $event = Event::findOrFail($id);
        $user = User::all();
        $tags = EventTags::all();
        $comments = EventComments::all();
        return view('/events/certain_event_view', ['event' => $event, 'users'=>$user, 'tags' => $tags, 'comments' => $comments]);
    }

    public function add_event_view()
    {
        $tags = EventTags::all();
    	return view('/events/add_event_view', ['tags' => $tags]);
    }

    public function add_org_view()
    {
    	return view('/events/add_org_view');
    }

    public function event_view()
    {
        $events = Event::all()->sortBy('date');
        $tags = EventTags::all();
    	return view('/events/event_view', ['events' => $events, 'tags' => $tags]);
    }

    public function add_event(Request $request)
    {
    	$event = new Event;
    	$event->name = $request->name;
    	$event->text = $request->text;
    	$event->date = $request->date;
    	$event->location = $request->location;
    	$event->type = $request->type;
    	$event->short_text = $request->short_text;
    	$event->max_people = $request->max_people;
    	$event->skills = $request->skills;
    	$event->site = $request->site;
        $event->save();
        $event->userOrgs()->attach(Auth::User()->id);
        if(isset($request->tags))
        {
            foreach ($request->tags as $tag)
            {
                $event->tags()->attach($tag);
            }
        }
        return redirect('/insider/events/'.$event->id);
    }

    public function del_event($id)
    {
    	$event = Event::findOrFail($id);
		$event->delete();
		return redirect('/insider/events');
    }

    public function go_event($id)
    {
    	$event = Event::findOrFail($id);
    	$event->userPartis()->attach(Auth::User()->id);
    	return redirect('/insider/events/'.$id);
    }

    public function left_event($id)
    {
        $event = Event::findOrFail($id);
        $event->userPartis()->detach(Auth::User()->id);
        return redirect('/insider/events/'.$id);
    }

    public function add_org($id)
    {
    	$event = Event::findOrFail($id);
    	$event->userOrgs()->attach(Auth::User()->id);
    	return redirect('/events');
    }

    public function del_org(Request $request)
    {
    	$event = Event::findOrFail($request->$id);
    	$event->orgs()->deattach($request->org_id);
    	$event->save();
    	return redirect('/event/'.$id);
    }

    public function like_event($id)
    {
        $event = Event::findOrFail($id);
        $event->userLikes()->attach(Auth::User()->id);
        return redirect('/insider/events/'.$id);
    }

    public function dislike_event($id)
    {
        $event = Event::findOrFail($id);
        $event->userLikes()->detach(Auth::User()->id);
        return redirect('/insider/events/'.$id);
    }
    public function add_comment(Request $request, $id)
    {
        $comment = new EventComments;
        $comment->user_id = Auth::User()->id;
        $comment->event_id = $id;
        $comment->text = $request->text;
        $comment->save();
        return redirect('/insider/events/'.$comment->event_id);
    }
}
