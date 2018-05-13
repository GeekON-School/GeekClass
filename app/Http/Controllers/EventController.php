<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Event;

class EventController extends Controller
{
    public function add_event_view()
    {
    	return view('/events/add_event_view');
    }

    public function add_org_view()
    {
    	return view('/events/add_org_view');
    }

    public function event_view()
    {
        $events = Event::all();
    	return view('/events/event_view', ['events' => $events]);
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
    	return redirect('/insider/events');
    }

    public function del_event($id)
    {
    	$event = Event::findOrFail($id);
		$event->delete();
		return redirect('/home');
    }

    public function go_event($id)
    {
    	$event = Event::findOrFail($id);
    	$event->participants()->attach(Auth::User()->id);
    	$event->save();
    	return redirect('/event/'.$id);
    }

    public function add_org(Request $request)
    {
    	$event = Event::findOrFail($request->$id);
    	$event->orgs()->attach($request->org_id);
    	$event->save();
    	return redirect('/event/'.$id);
    }

    public function del_org(Request $request)
    {
    	$event = Event::findOrFail($request->$id);
    	$event->orgs()->deattach($request->org_id);
    	$event->save();
    	return redirect('/event/'.$id);
    }
}
