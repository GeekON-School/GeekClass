@extends('layouts.left-menu')

@section('title')
    GeekClass
@endsection

@section('content')


    @if($user->isBirthday())
        <div class="row">
            <div class="col">
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h3>
                        <img src="https://png.icons8.com/color/50/000000/confetti.png"> <img
                                src="https://png.icons8.com/color/50/000000/confetti.png"> <img
                                src="https://png.icons8.com/color/50/000000/confetti.png">
                        <span>С днем рождения!!!</span> <img
                                src="https://png.icons8.com/color/50/000000/confetti.png">
                        <img
                                src="https://png.icons8.com/color/50/000000/confetti.png"> <img
                                src="https://png.icons8.com/color/50/000000/confetti.png"></h3>
                </div>
            </div>
        </div>
    @endif

    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <h2>Мои курсы</h2>
        </div>
        <div class="col">
            @if ($user->role=='teacher' || $user->role=='admin')
                <ul class="nav nav-tabs nav-fill" id="coursesTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active" role="tab"
                           aria-controls="active" aria-selected="true">Мои курсы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="draft-tab" data-toggle="tab" href="#draft" role="tab"
                           aria-controls="draft" aria-selected="false">Черновики</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="archive-tab" data-toggle="tab" href="#archive" role="tab"
                           aria-controls="archive" aria-selected="false">Архив</a>
                    </li>

                        <li class="nav-item" style="margin-left: 5px;">
                            <a class="btn btn-success btn-sm nav-link" style="color: white;"  href="{{url('/insider/courses/create/')}}"><i
                                        class="icon ion-plus-round" style="color: white;"></i>&nbsp;Создать</a>
                        </li>

                </ul>





            @else
                <div class="float-right">
                    <form autocomplete="off" class="form-inline" method="get" action="{{url('insider/invite')}}">
                        <input autocomplete="false" name="hidden" type="text" style="display:none;">
                        {{csrf_field()}}
                        <input type="text" class="form-control form-control-sm mb-2 mr-sm-2 mb-sm-0" id="invite"
                               name="invite" placeholder="Инвайт на курс">

                        <button type="submit" class="btn btn-success btn-sm"><i class="icon ion-plus-round" style="color: white;"></i>&nbsp;Добавить
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <div class="tab-content" id="courses">
        <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active">

            <div class="row">
                <div class="col-12 col-lg-7 col-xl-8">
                    @if ($my_courses->count()!=0)
                        <div class="card-deck">
                            @foreach($my_courses->where('state', 'started') as $course)
                                <div class="card"
                                     style="min-width: 280px; background-image: url({{$course->image}}); background-size: cover; @if (!$course->is_open) border-left: 3px solid #28a745;@else border-left: 3px solid #17a2b8; @endif">
                                    <div class="card-body" style="background-color: rgba(255,255,255,0.9);">
                                        <h5 style="font-weight: 300;"
                                            class="card-title">
                                            <a href="{{url('insider/courses/'.$course->id)}}"
                                               style="color: #333741;">{{$course->name}}</a>

                                        </h5>
                                        <p class="card-text"
                                           style="font-size: 0.8rem;">{{$course->description}}</p>
                                        @if (!$course->is_sdl)
                                            @if ($course->students->contains($user))
                                                @php
                                                    $percent = round($course->getPercent($user));
                                                @endphp
                                                @if ($percent < 40)
                                                    <span class="badge badge-warning">Выполнено {{$percent}}%</span>
                                                @else
                                                    @if ($percent < 80)
                                                        <span class="badge badge-info">Выполнено {{$percent}}%</span>
                                                    @else
                                                        <span class="badge badge-success">Выполнено {{$percent}}%</span>
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                        <div style="float:right;">
                                            @php 
                                                $students = $course->students;
                                                $cstudent = $students->filter(function ($value, $key) {
                                                    return $value->id == \Auth::id();
                                                })->first();
                                            @endphp
                                            @if ($cstudent != null)
                                            @foreach($course->program->chapters as $chapter)
                                                @foreach($chapter->lessons as $lesson)
                                                    @foreach($lesson->steps as $step)
                                                        @php
                                                            if ($cstudent->pivot->is_remote)
                                                            {
                                                            $tasks = $step->remote_tasks;
                                                            }
                                                            else {
                                                            $tasks = $step->class_tasks;
                                                            }
                                                        @endphp
                                                        @foreach($tasks as $task)
                                                            @if ($task->deadline)
                                                                <style>
                                                                    *[data-tooltip]
                                                                    {
                                                                        position: relative;
                                                                    }
                                                                    *[data-tooltip]::before {
                                                                        content: attr(data-tooltip);
                                                                        position: absolute;
                                                                        padding: 2px 10px;
                                                                        border-radius: 3px;
                                                                        color:#fff;
                                                                        background: #333741;
                                                                        display: none;
                                                                        top:20px;
                                                                        left:-100%;
                                                                    }
                                                                    *[data-tooltip]:hover::before {
                                                                        display: block;
                                                                    }
                                                                </style>
                                                                @if (\Carbon\Carbon::now()->gt($task->deadline))
                                                            <span class="badge badge-danger" data-tooltip="{{$task->name}}" onclick="location.href='/insider/courses/{{$course->id}}/steps/{{$step->id}}#task{{$task->id}}'" style="cursor:pointer;">
                                                                        !
                                                                    </span>
                                                                @elseif (\Carbon\Carbon::now()->addDays(1)->gt($task->deadline))
                                                                <span class="badge badge-warning" data-tooltip="{{$task->name}}" onclick="location.href='/insider/courses/{{$course->id}}/steps/{{$step->id}}#task{{$task->id}}'" style="cursor:pointer;">
                                                                        !
                                                                    </span>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                            @endif
                                        </div>
                                        @if ($course->site != null)
                                            <a target="_blank" href="{{$course->site}}"
                                               style="margin-top: 6px; font-size: 0.8rem;"
                                               class="float-right">О курсе</a>
                                        @endif


                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @else
                        <p>Вы пока не записаны на курсы.</p>
                    @endif

                    @if ($user->role!='admin' )
                        <h5 style="margin-top: 15px;">Открытые курсы</h5>
                        @if ($open_courses->count() != 0)
                            <div class="card-deck">
                                @foreach($open_courses as $course)

                                    <div class="card"
                                         style="min-width: 280px; background-image: url({{$course->image}}); border-left: 3px solid #17a2b8;">
                                        <div class="card-body"
                                             style="background-color: rgba(255,255,255,0.9);">
                                            <h5 style="font-weight: 300;"
                                                class="card-title">{{$course->name}}</h5>
                                            <p class="card-text"
                                               style="font-size: 0.8rem;">{{$course->description}}</p>
                                            <a href="{{ url('/insider/courses/'.$course->id.'/enroll') }}"
                                               class="btn btn-info btn-sm">Записаться</a>

                                            @if ($course->site != null)
                                                <a target="_blank" href="{{$course->site}}"
                                                   style="margin-top: 6px; font-size: 0.8rem;"
                                                   class="float-right">О курсе</a>
                                            @endif


                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>Сейчас нет доступных открытых курсов. Ну или вы просто записались на все! :)</p>
                        @endif

                        <h5 style="margin-top: 15px;">Приватные курсы</h5>
                        @if ($private_courses->count() != 0)
                            <div class="card-deck">
                                @foreach($private_courses as $course)

                                    <div class="card"
                                         style="min-width: 280px; background-image: url({{$course->image}}); border-left: 3px solid #f8f9fa;">
                                        <div class="card-body"
                                             style="background-color: rgba(255,255,255,0.9);">
                                            <h5 style="font-weight: 300;"
                                                class="card-title">{{$course->name}}</h5>
                                            <p class="card-text"
                                               style="font-size: 0.8rem;">{{$course->description}}</p>

                                            <a href="https://goo.gl/forms/jMsLU855JBFaZRQE2" target="_blank"
                                               class="btn btn-info btn-sm">Оставить заявку</a>

                                            @if ($course->site != null)
                                                <a target="_blank" href="{{$course->site}}"
                                                   style="margin-top: 6px; font-size: 0.8rem;"
                                                   class="float-right">О курсе</a>
                                            @endif


                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        @else
                            <p>Сейчас нет доступных приватных курсов.</p>
                        @endif
                    @endif
                </div>

                <div class="col-12  col-lg-5 col-xl-4">

                    <div class="card"
                         style="margin-top: 15px;border-left: 3px solid #007bff;">
                        <div class="card-body">

                            <div class="row">
                                <div class="col" style="width: 85px; max-width: 85px;">
                                    @if ($user->image!=null)
                                        <div class="mr-3 rounded-circle img-circle"
                                             style='background-image: url("{{url('/media/'.$user->image)}}");'>
                                        </div>
                                    @else
                                        <div class="mr-3 rounded-circle img-circle"
                                             style='background-image: url("http://api.adorable.io/avatars/256/{{$user->id}}");'>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-auto" style="width: calc(100% - 100px); max-width: calc(100% - 100px)">
                                    <h5>
                                        <a href="{{url('/insider/profile/'.$user->id)}}">{{ $user->name }}</a>
                                    </h5>
                                    <p><a tabindex="0" data-toggle="popover" data-trigger="focus" title="Ранги"
                                          data-html="true"
                                          data-content="{{\App\Rank::getRanksListHTML($user->rank())}}"><span
                                                    style="font-size: 13px;" class="badge badge-pill badge-success"><i
                                                        class="icon ion-ios-arrow-up"></i> {{$user->rank()->name}}</span></a>

                                        @if ($user->is_trainee)
                                            <span style="font-size: 13px;"
                                                  class="badge badge-pill badge-info">Стажер</span>
                                        @endif
                                        @if ($user->is_teacher)
                                            <span style="font-size: 13px;"
                                                  class="badge badge-pill badge-info">Преподаватель</span>
                                        @endif

                                        <span style="margin-top: 8px;" data-container="body"
                                              data-placement="bottom"
                                              data-content="{!! $user->getHtmlTransactions() !!}"
                                              data-html="true" data-toggle="popover">
                                           <img src="https://png.icons8.com/color/50/000000/coins.png"
                                                style="height: 30px;"/>&nbsp;{{$user->balance()}}&nbsp;&nbsp;

                                        </span>

                                    </p>

                                </div>
                            </div>

                            <p><strong>Дата
                                    рождения:</strong> @if($user->birthday!=null){{$user->birthday->format('Y-m-d')}}@endif
                                <br>
                                <strong>Место учебы:</strong> {{$user->school}}<br>
                                <strong>Класс:</strong> {{$user->grade()}}</p>

                            <div class="progress" style="margin-bottom: 15px;">
                                <div class="progress-bar" role="progressbar"
                                     style="width:{{100*($user->score()-$user->rank()->from)/($user->rank()->to-$user->rank()->from)}}%;"
                                     aria-valuenow="{{$user->score()}}" aria-valuemin="{{$user->rank()->from}}"
                                     aria-valuemax="{{$user->rank()->to}}">{{$user->score()}}</div>
                            </div>

                            @foreach($user->getStickers() as $sticker)
                                <img src="{{url($sticker)}}"
                                     style="max-height: 35px;"/>
                            @endforeach


                            <p class="card-text" style="font-size: 0.8rem;">
                            </p>

                        </div>

                    </div>

                    <div class="card"
                         style="margin-top: 15px;border-left: 3px solid #007bff;">
                        <div class="card-body">

                            <h5 style="margin-top: 15px; font-weight: 400; font-size: 1.1rem;"
                                class="card-title">Празднуем день рождения:</h5>
                            <p class="card-text" style="font-size: 0.8rem;">
                            <ul>
                                @foreach($users->where('birthday', '!=', null)->sortBy(function($col){return $col->birthday->day;}) as $buser)
                                    @if ($buser->birthday->month == \Carbon\Carbon::now()->month and ($buser->birthday->day > \Carbon\Carbon::now()->day - 10 and $buser->birthday->day < \Carbon\Carbon::now()->day + 10))
                                        <li>
                                            <a style="color: black; @if ($buser->birthday->day == \Carbon\Carbon::now()->day and $buser->birthday->month == \Carbon\Carbon::now()->month) font-weight: bold; @endif"
                                               href="{{url('insider/profile/'.$buser->id)}}">{{ $buser->name }}</a>
                                            -
                                            <strong>{{$buser->birthday->format('d.m')}}</strong></li>
                                    @endif
                                @endforeach
                            </ul>
                            </p>

                        </div>

                    </div>


                    <div class="card"
                         style="border-left: 3px solid #007bff">
                        <div class="card-body">
                            <h5 style="margin-top: 15px; font-weight: 400; font-size: 1.1rem;"
                                class="card-title">Последние вопросы:</h5>
                            <p class="card-text" style="font-size: 0.8rem;">
                            <ul>
                                @foreach($threads as $thread)
                                    <li>
                                        <a style="color: black; @if ($buser->birthday->day == \Carbon\Carbon::now()->day) font-weight: bold; @endif"
                                           href="{{url('insider/forum/'.$thread->id)}}">{{ $thread->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            </p>
                        </div>

                    </div>

                </div>


            </div>

        </div>

        @if ($user->role == 'teacher' || $user->role=='admin' )
            <div class="tab-pane fade" id="draft" role="tabpanel" aria-labelledby="draft">
                <div class="row" style="margin-top: 15px;">
                    <div class="card-deck">
                        @foreach($courses->where('state', 'draft') as $course)
                            @if ($user->role=='admin' || $course->teachers->contains($user))
                                <div class="card"
                                     style="min-width: 280px; background-image: url({{$course->image}}); background-size: cover;">
                                    <!--<img class="card-img-top" src="..." alt="Card image cap">-->
                                    <div class="card-body" style="background-color: rgba(255,255,255,0.9);">
                                        <h4 class="card-title">{{$course->name}}</h4>
                                        <p class="card-text" style="font-size: 0.8rem;">{{$course->description}}</p>

                                    </div>
                                    <div class="card-footer" style="background-color: rgba(245,245,245,1);">
                                        <a href="{{url('insider/courses/'.$course->id)}}"
                                           class="btn btn-success btn-sm">Страница
                                            курса</a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                </div>

            </div>
            <div class="tab-pane fade" id="archive" role="tabpanel" aria-labelledby="archive">
                <div class="row" style="margin-top: 15px;">
                    @foreach($courses->where('state', 'ended')->sortByDesc('start_date') as $course)
                        @if ($user->role=='admin' || $course->teachers->contains($user))
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <h5 style="padding: 0; margin: 0;" class="card-title">{{$course->name}}
                                                    <br>
                                                    <small style="font-size: 70%;">{{$course->start_date->format('d.m.Y')}}
                                                        - {{$course->end_date->format('d.m.Y')}}</small>
                                                </h5>

                                            </div>
                                            <div class="col-md-3">
                                                <a href="{{url('insider/courses/'.$course->id)}}"
                                                   class="btn btn-success btn-sm  float-right">Страница</a>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        @endif

                    @endforeach
                </div>


            </div>
        @endif
    </div>

@endsection
