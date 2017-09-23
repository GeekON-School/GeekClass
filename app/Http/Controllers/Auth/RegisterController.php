<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
use App\Course;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'insider/courses';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'name' => 'required|string',
            'school' => 'required|string',
            'grade' => 'required|integer',
            'birthday' => 'required|date|date_format:Y-m-d',
            'hobbies' => 'required|string',
            'interests' => 'required|string',
            'image' => 'image|max:1000'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create($data)
    {


        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $user->vk = $data->vk;
        $user->git = $data->git;
        $user->facebook = $data->facebook;
        $user->telegram = $data->telegram;
        $user->hobbies = $data->hobbies;
        $user->interests = $data->interests;
        $user->school = $data->school;
        $user->birthday = Carbon::createFromFormat('Y-m-d', $data->birthday);
        $user->setGrade($data->grade);

        if ($data->hasFile('image'))
        {
            $extn = '.'.$data->file('image')->guessClientExtension();
            $path = $data->file('image')->storeAs('user_avatars', $user->id.$extn);
            $user->image = $path;
        }

        $user->save();
        return $user;
    }

    public function register(Request $request)
    {
        if ($request->invite==null || $request->invite=="")
        {
            $this->make_error_alert('Ошибка!', 'Курс с таким приглашением не найден.');
            return $this->backException();
        }
        $course = Course::where('invite', $request->invite)->first();
        if ($course==null)
        {
            $this->make_error_alert('Ошибка!', 'Курс с таким приглашением не найден.');
            return $this->backException();
        }

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request)));
        $course->students()->attach($user->id);

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
