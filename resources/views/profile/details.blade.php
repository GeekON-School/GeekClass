@extends('layouts.app')

@section('content')
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-4">

            <div class="card">
                <img class="card-img-top"
                     src="{{url('/media/'.$user->image)}}"/>
                <div class="card-body">
                    <h4 class="card-title">{{$user->name}}</h4>

                    <p><strong>Дата
                            рождения:</strong> @if($user->birthday!=null){{$user->birthday->format('Y-m-d')}}@endif<br>
                        <strong>Место учебы:</strong> {{$user->school}}<br>
                        <strong>Класс:</strong> {{$user->grade()}}</p>

                    <div class="progress">
                        <div class="progress-bar" role="progressbar"
                             style="width:{{100*($user->score()-$user->rank()->from)/($user->rank()->to-$user->rank()->from)}}%;"
                             aria-valuenow="{{$user->score()}}" aria-valuemin="{{$user->rank()->from}}"
                             aria-valuemax="{{$user->rank()->to}}">{{$user->score()}}</div>
                    </div>
                    <p style="margin-top: 15px;">
                        <span style="font-size: 15px;" class="badge badge-pill badge-success"><i
                                    class="icon ion-ios-arrow-up"></i> {{$user->rank()->name}}</span><br>
                        @if ($user->is_trainee)
                            <span class="badge badge-pill badge-info">Стажер</span>
                        @endif
                        @if ($user->is_teacher)
                            <span class="badge badge-pill badge-info">Преподаватель</span>
                        @endif
                    </p>
                </div>
                <ul class="list-group list-group-flush">
                    @if ($user->telegram!='')
                        <li class="list-group-item"><img src="https://png.icons8.com/telegram-app/win10/16"
                                                         title="Telegram App" width="16"
                                                         height="16"><strong> Telegram: </strong>
                            {{$user->telegram}}</li>
                    @endif
                    @if ($user->git!='')
                        <li class="list-group-item"><img src="https://png.icons8.com/git/color/24" title="Git"
                                                         width="16" height="16"><strong> Git: </strong>
                            {{$user->git}}</li>
                    @endif
                    @if ($user->vk!='')
                        <li class="list-group-item"><img src="https://png.icons8.com/vkontakte/color/24"
                                                         title="VKontakte" width="16"
                                                         height="16">
                            <strong> VK: </strong>
                            {{$user->vk}}</li>
                    @endif
                    @if ($user->facebook!='')
                        <li class="list-group-item"><img src="https://png.icons8.com/facebook/color/24" title="Facebook"
                                                         width="16"
                                                         height="16"><strong> Facebook: </strong>
                            {{$user->facebook}}</li>
                    @endif
                </ul>


            </div>

        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">О себе
                        @if ($guest->role=='teacher' || $guest->id==$user->id)
                            <a class="btn btn-sm btn-success float-right"
                               href="{{'/insider/profile/'.$user->id.'/edit'}}"><i class="icon ion-android-create"></i> Редактировать</a>
                        @endif
                    </h4>
                    <p><strong>Технологические интересы:</strong><br>{{$user->interests}}</p>
                    <p><strong>Увлечения:</strong><br>{{$user->hobbies}}</p>
                    @if ($guest->role=='teacher')
                        <p><strong>Комментарий:</strong><br>{{$user->comments}}</p>
                    @endif
                </div>
            </div>
            @if($user->managed_courses->count()!=0)
                <h4 style="margin: 20px;" class="card-title">Преподаватель в курсах <img src="https://png.icons8.com/school-director/color/30/000000"></h4>
                <div class="row">
                    @foreach($user->managed_courses as $course)
                        @if ($course->state == 'started')
                            <div class="col-md-6">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{$course->name}}</h5>
                                        <p>
                                            <span class="badge badge-pill badge-{{$course->provider->color}}">{{$course->provider->short_name}}</span>
                                        </p>
                                        @if ($guest->role=='teacher' || $course->students->contains($guest))
                                            <a href="{{url('insider/courses/'.$course->id)}}" class="card-link">Страница
                                                курса</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
            @if($user->courses()->where('state', 'started')->count()!=0)
                <h4 style="margin: 20px;" class="card-title"> Текущие курсы <img
                            src="https://png.icons8.com/graduation-cap/color/30/000000"></h4>
                <div class="row">
                    @foreach($user->courses as $course)
                        @if ($course->state == 'started')
                            <div class="col-md-6">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{$course->name}}</h5>
                                        <p>
                                            <span class="badge badge-pill badge-{{$course->provider->color}}">{{$course->provider->short_name}}</span>
                                        </p>
                                        @if ($guest->role=='teacher' || $course->students->contains($guest))
                                            <a href="{{url('insider/courses/'.$course->id)}}" class="card-link">Страница
                                                курса</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

            @if($user->completedCourses->count()!=0 || $guest->role=='teacher')
                <div class="row">
                    <div class="col-md-8">
                        <h4 style="margin: 20px;" class="card-title">Завершенные курсы <img
                                    src="https://png.icons8.com/gold-medal/color/30/000000"></h4>
                    </div>
                    <div class="col" style="padding-top: 19px;">
                        @if ($guest->role=='teacher')
                            <button style="margin-right: 5px;" type="button" class="float-right btn btn-sm btn-primary"
                                    data-toggle="modal" data-target="#exampleModal">
                                <i class="icon ion-plus-round"></i> Добавить
                            </button>
                        @endif
                    </div>
                </div>
                <div class="row">
                    @foreach($user->completedCourses as $course)
                        <div class="col-md-6">
                            <div class="card" style="width: 100%; margin-bottom: 10px;">
                                <div class="card-body">
                                    <h5 class="card-title">{{$course->name}}
                                        @if ($guest->role=='teacher')
                                            <a class="float-right"
                                               href="{{url('/insider/profile/delete-course/'.$course->id)}}"><span
                                                        aria-hidden="true">&times;</span></a>
                                        @endif</h5>
                                    <p>
                                        <span class="badge badge-pill badge-{{\App\CourseLabel::get($course)}}">{{$course->provider}}</span>
                                        <span class="badge badge-pill badge-success">Оценка: <strong>{{$course->mark}}</strong></span>
                                        @if ($course->course_id!=null && ($guest->role=='teacher' || $course->course->students->contains($guest)))
                                            <br>
                                            <br>

                                            <a href="{{url('insider/courses/'.$course->course_id)}}"
                                               class="btn btn-sm btn-primary">Страница
                                                курса</a>

                                        @endif
                                    </p>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if ($user->projects->count()!=0 || $guest->role=='teacher')
                <div class="row">
                    <div class="col-md-8">
                        <h4 style="margin: 20px;" class="card-title">Проекты <img
                                    src="https://png.icons8.com/microsoft-project/color/30/000000"></h4>
                    </div>
                    <div class="col" style="padding-top: 19px;">
                        @if ($guest->role=='teacher' || $guest->id==$user->id)
                            <button style="margin-right: 5px;" type="button" class="float-right btn btn-sm btn-primary"
                                    data-toggle="modal" data-target="#createProject">
                                <i class="icon ion-plus-round"></i> Добавить
                            </button>
                        @endif
                    </div>

                </div>

                <div class="row">
                    @foreach($user->projects as $project)
                        <div class="col-md-6">
                            <div class="card" style="width: 100%; margin-bottom: 10px;">
                                <div class="card-body">
                                    <h5 class="card-title">{{$project->name}}</h5>
                                    <p><span>{{$project->short_description}}</span></p>
                                    <a href="{{url('insider/projects/'.$project->id)}}" class="card-link">Страница
                                        проекта</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @foreach($events as $event)
                @if($event->userPartis->contains($user->id) && (\Carbon\Carbon::createFromFormat('Y-m-d', $event->date)->lt(\Carbon\Carbon::now())))
                    <div class="row">
                        <div class="col-md-8">
                            <h4 style="margin: 20px;" class="card-title">Прошедшие события
                                <img src="https://png.icons8.com/ultraviolet/50/000000/overtime.png" width="25px">
                            </h4>
                        </div>
                    </div>
                    @break
                @endif
            @endforeach

            <div class="row">
                @foreach($events as $event)
                    @if($event->userPartis->contains($user->id) && (\Carbon\Carbon::createFromFormat('Y-m-d', $event->date)->lt(\Carbon\Carbon::now())))
                        <div class="col-md-6">
                            <div class="card" style="width: 100%; margin-bottom: 10px;">
                                <div class="card-footer">
                                    <div class="float-left">
                                        <h5 class="card-title">{{$event->name}}</h5>
                                    </div>
                                    <div class="float-right" style="margin-right:5px">
                                        {{$event->date}}
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="float-left"><span>{{$event->short_text}}</span></div>
                                    <div class="float-right">
                                        <a href="{{url('insider/events/'.$event->id)}}" class="btn btn-sm btn-primary">Страница
                                            события</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            @foreach($events as $event)
                @if($event->userPartis->contains($user->id) && (\Carbon\Carbon::createFromFormat('Y-m-d', $event->date)->gt(\Carbon\Carbon::now())))
                    <div class="row">
                        <div class="col-md-8">
                            <h4 style="margin: 20px;" class="card-title">События <img
                                src="https://png.icons8.com/ultraviolet/50/000000/today.png" width="25px">
                            </h4>
                        </div>
                    </div>
                    @break
                @endif
            @endforeach

            <div class="row">
                @foreach($events as $event)
                    @if($event->userPartis->contains($user->id) && (\Carbon\Carbon::createFromFormat('Y-m-d', $event->date)->gt(\Carbon\Carbon::now())))
                        <div class="col-md-6">
                            <div class="card" style="width: 100%; margin-bottom: 10px;">
                                    <div class="card-footer">
                                        <div class="float-left">
                                            <h5 class="card-title">{{$event->name}}</h5>
                                        </div>
                                        <div class="float-right" style="margin-right:5px">
                                            {{$event->date}}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="float-left"><span>{{$event->short_text}}</span></div>
                                        <div class="float-right">
                                            <a href="{{url('insider/events/'.$event->id)}}" class="btn btn-sm btn-primary">Страница
                                                события</a>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавление курса</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('/insider/profile/'.$user->id.'/course')}}" method="POST"
                          class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4">Название</label>

                            <div class="col-md-12">
                                <input type="text" name="name" class="form-control" id="name"/>
                                @if ($errors->has('name'))
                                    <span class="help-block error-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('mark') ? ' has-error' : '' }}">
                            <label for="mark" class="col-md-4">Оценка</label>

                            <div class="col-md-12">
                                <input type="text" name="mark" class="form-control" id="mark"/>
                                @if ($errors->has('mark'))
                                    <span class="help-block error-block">
                                        <strong>{{ $errors->first('mark') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('provider') ? ' has-error' : '' }}">
                            <label for="provider" class="col-md-4">Организация</label>

                            <div class="col-md-12">
                                <input type="text" name="provider" class="form-control" id="provider"/>
                                @if ($errors->has('provider'))
                                    <span class="help-block error-block">
                                        <strong>{{ $errors->first('provider') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">Создать</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createProject" tabindex="-1" role="dialog"
         aria-labelledby="exampleModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModelLabel">Добавление проекта</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('/insider/projects/create')}}" method="POST"
                          class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4">Название</label>

                            <div class="col-md-12">
                                <input type="text" name="name" class="form-control" id="name"/>
                                @if ($errors->has('name'))
                                    <span class="help-block error-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('short_description') ? ' has-error' : '' }}">
                            <label for="short_description" class="col-md-4">Краткое описание</label>

                            <div class="col-md-12">
                                <textarea name="short_description" class="form-control"
                                          id="short_description"></textarea>
                                @if ($errors->has('short_description'))
                                    <span class="help-block error-block">
                                        <strong>{{ $errors->first('short_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    <!--  <div class="form-group{{ $errors->has('projectType') ? ' has-error' : '' }}">
                            <label for="short_description" class="col-md-4">Тип</label>

                            <div class="col-md-12">
                                <select name="projectType" class="form-control" id="projectType"/>
                                    <option value="None selected">Выберите тип проекта</option>
                                    <option value="Learning">Учебный</option>
                                    <option value="Working">Рабочий</option>
                                </select>
                                @if ($errors->has('short_description'))
                        <span class="help-block error-block">
                            <strong>{{ $errors->first('short_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>-->


                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">Создать</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
