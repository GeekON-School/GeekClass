<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventComment;
use Illuminate\Support\Facades\Auth;


class EventCommentsController extends Controller
{
    public function addComment(Request $request)
    {
    	$comm = new EventComment;
    	$comm->user_id = Auth::User()->id;
    	$comm->text = $request->text;
    	$comm->event_id = $request->event_id;
    	$comm->save();
    	return redirect('/event/'.$request->event_id)
    }
}
