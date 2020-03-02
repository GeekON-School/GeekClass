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

    public function feedback_view(Request $request)
    {
        $user = \Auth::user();
        $key = $request->key;

        $queries = DetailedFeedback::getForms($user, $key);

        if (count($queries) == 0)
        {
            abort(404);
        }

        $date = $queries[0]->created_at;

    }
}
