<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    protected $table = "courses";

    protected $fillable = [
        'name', 'description', 'image', 'start_date', 'end_date', 'state', 'level', 'invite'
    ];

    protected $dates = [
        'start_date', 'end_date'
    ];

    public function students()
    {
        return $this->belongsToMany('App\User', 'course_students', 'course_id', 'user_id')->withPivot('is_remote');
    }

    public function provider()
    {
        return $this->hasOne('App\Provider', 'id', 'provider_id');
    }

    public function teachers()
    {
        return $this->belongsToMany('App\User', 'course_teachers', 'course_id', 'user_id');
    }

    public function steps()
    {
        return $this->hasMany('App\CourseStep', 'course_id', 'id')->orderBy('sort_index')->orderBy('id');
    }

    public function lessons()
    {
        return $this->hasMany('App\Lesson', 'course_id', 'id')->with('steps')->orderBy('sort_index')->orderBy('id');
    }

    public static function createCourse($data)
    {
        $course = Course::create(['name' => $data['name'], 'description' => $data['description']]);
        $course->teachers()->attach(Auth::User()->id);
        return $course;
    }

    public function start()
    {
        $this->state = 'started';
        $this->start_date = Carbon::now();
        do {
            $invite = str_random(8);
        } while (Course::where('invite', $invite)->count() != 0);
        $this->invite = $invite;
        $this->remote_invite = $invite . '-R';
        $this->save();
    }

    public function points(User $student)
    {
        $sum = 0;
        foreach ($this->lessons as $step)
            $sum += $step->points($student);
        return $sum;
    }

    public function max_points(User $student)
    {
        $sum = 0;
        foreach ($this->steps as $step)
            $sum += $step->max_points($student);
        return $sum;
    }

    public function end()
    {
        $this->state = 'ended';
        $this->end_date = Carbon::now();

        CompletedCourse::where('course_id', $this->id)->delete();

        $cert_request = ['courses' => []];

        array_push($cert_request['courses'], [
            'name' => $this->name,
            'date' => Carbon::now()->format('d.m.Y'),
            'teachers' => [
                ['name' => $this->teachers[0]->name]
            ],
            'students' => []

        ]);

        foreach ($this->students as $student) {
            array_push($cert_request['courses'][0]['students'], [
                'id' => $student->id,
                'name' => $student->name,
                'mark' => Mark::getMark($this->points($student), $this->max_points($student))
            ]);
        }

        $client = new \GuzzleHttp\Client();
        $res = $client->post('https://cert.geekclass.ru', [
            'body' => json_encode($cert_request)
        ]);
        $cert_result = json_decode($res->getBody()->getContents());



        foreach ($this->students as $student) {
            $completed_course = new CompletedCourse();
            $completed_course->name = $this->name;
            $completed_course->provider = $this->provider->short_name;
            $completed_course->user_id = $student->id;
            $completed_course->course_id = $this->id;
            $id = $student->id;
            $completed_course->cert_link = $cert_result->$id->link;
            $completed_course->mark = Mark::getMark($this->points($student), $this->max_points($student));
            $completed_course->save();
        }

        $this->save();
    }

    public function export()
    {
        $export = collect([]);
        $lessons = $this->lessons;
        foreach ($lessons as $lesson) {
            $export->push(json_decode($lesson->export()));
        }
        return $export->toJson();
    }

    public function import($course_json)
    {
        $lessons = json_decode($course_json);
        foreach ($lessons as $lesson) {
            $steps = $lesson->steps;
            unset($lesson->steps);

            $new_lesson = new Lesson();
            foreach ($lesson as $property => $value)
                $new_lesson->$property = $value;
            $new_lesson->course_id = $this->id;
            $new_lesson->save();

            $lesson->steps = $steps;
            $new_lesson->import(json_encode($lesson));

        }

    }
}
