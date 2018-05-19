<?php

namespace App\Http\Controllers;

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
        return view('/events/certain_event_view', ['event' => $event, 'users'=>$user, 'tags' => $tags]);
    }

    public function add_event_view()
    {
        $tags = EventTags::all();
    	return view('/events/add_event_view', ['tags' => $tags]);
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

    public function add_org(Request $request)
    {
    	$event = Event::findOrFail($request->id);
    	$users = User::all();
    	foreach($users as $user) {
    	    if($user->name == $request->name) {
    	        $event->userOrgs()->attach($user->id);
    	        break;
            }
        }
    	return redirect('/insider/events/'.$event->id);
    }

    public function del_org(Request $request)
    {
    	$event = Event::findOrFail($request->id);
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
}
