<?php

namespace App\Http\Controllers;

use App\DetailedFeedback;
use Illuminate\Http\Request;

class DetailedFeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function feedback_view($key, Request $request)
    {
        $user = \Auth::user();
        $queries = DetailedFeedback::getForms($user, $key);

        return view('/feedback/form', compact('queries'));
    }

    public function feedback($key, Request $request)
    {
        $user = \Auth::user();
        $queries = DetailedFeedback::getForms($user, $key);

        foreach ($queries as $query) {
            if ($request->has($query->id.'_missed')) {
                $query->is_missed = true;
            }
            else {
                $this->validate($request, [ $query->id.'_mark' => 'required|integer|min:1|max:5'] );
                $query->mark = (int) $request->get($query->id.'_mark');

                if (!$request->has($query->id.'_not_late')) $query->is_late = true;
                if (!$request->has($query->id.'_ready')) $query->is_unprepaired = true;
                if ($request->has($query->id.'_need_contact')) $query->need_communication = true;

            }

            $query->is_filled = true;
            $query->save();
        }

        return redirect('/');
    }
}
