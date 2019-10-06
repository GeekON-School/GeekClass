<?php

namespace App\Console\Commands;

use App\Course;
use Illuminate\Console\Command;
use Log;

class RequestFeedback extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feedback';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $courses = Course::where('state', 'started')->where('weekdays', '!=', '')->get()->filter(function ($course) {
            $current = \Carbon\Carbon::now()->dayOfWeek;
            if ($current == 0) $current = 7;
            return in_array(strval($current), explode( ';', $course->weekdays));
        });

        $students = collect([]);

        foreach ($courses as $course)
        {
            foreach ($course->students as $student)
            {
                if ($student->vk_id == null) continue;
                if (!$students->contains($student)) $students->push($student);
            }
        }

        Log::info($students->pluck('id'));

        try {
            $client = new \GuzzleHttp\Client();
            $client->post(config('bot.vk_bot') . '/feedback', [
                'form_params' => [
                    'users' => \GuzzleHttp\json_encode($students->pluck('id')),
                    'key' => config('bot.vk_bot_key')
                ]
            ]);
        }
        catch (\Exception $e)
        {
            Log::info($$e);
        }
    }
}
