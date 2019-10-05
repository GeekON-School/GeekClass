<?php

namespace App\Http\Controllers;

use App\CompletedCourse;
use App\Course;
use App\EducationalResult;
use App\MarketDeal;
use App\MarketGood;
use App\Notifications\NewOrder;
use App\Program;
use App\ProgramStep;
use App\Http\Controllers\Controller;
use App\Provider;
use App\ResultScale;
use App\Task;
use App\User;
use App\Lesson;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class BotController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }


    public function activateView()
    {
        return view('bot.activate');
    }

    public function activate(Request $request)
    {
        $code = $request->code;

        $client = new \GuzzleHttp\Client();
        $res = $client->post(config('bot.vk_bot').'/activate', [
            'form_params' => [
                'code' => $code,
                'class_id' => Auth::User()->id,
            ]
        ]);
        $result = $res->getBody()->getContents();

        if ($result == "ok")
        {
            return redirect('/activate/success');
        }
        else {
            return redirect()->back()->withErrors(array('code' => 'Проверьте правильность кода...'));
        }
    }

    public function successView()
    {
        return view('bot.activate');
    }


}
