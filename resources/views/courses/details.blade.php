@extends('layouts.app')

@section('title')
    GeekClass: "{{$course->name}}"
@endsection

@section('tabs')

@endsection



@section('content')
    <div class="row">
        <div class="col">
            <h2 style="font-weight: 300;">{{$course->name}}</h2>
            <p>{{$course->description}}</p>
        </div>
        @if ($user->role=='teacher')
            <div class="col">
                <div class="float-right">
                    <a href="{{url('/insider/courses/'.$course->id.'/create')}}" class="btn btn-primary btn-sm"><i
                                class="icon ion-compose"></i></a>
                    <a href="{{url('/insider/courses/'.$course->id.'/edit')}}"
                       class="btn btn-primary btn-sm"><i
                                class="icon ion-android-create"></i></a>
                    <a href="{{url('/insider/courses/'.$course->id.'/export')}}"
                       class="btn btn-primary btn-sm"><i
                                class="icon ion-ios-cloud-download"></i></a>
                    @if ($course->state=="draft")
                        <a href="{{url('/insider/courses/'.$course->id.'/start')}}"
                           class="btn btn-success btn-sm"><i
                                    class="icon ion-power"></i></a>
                    @elseif ($course->state=="started")
                        <a href="{{url('/insider/courses/'.$course->id.'/stop')}}"
                           class="btn btn-danger btn-sm"><i
                                    class="icon ion-stop"></i></a>
                    @endif
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-8">
            
            @if ($course->state=="ended" and $user->role=='teacher')
                <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5>Сертификаты</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <ul>
                                        @foreach($marks as $mark)
                                            @if ($mark->cert_link!= null and $mark->mark != 'D')
                                                <li>{{$mark->cert_link}}</li>
                                            @endif
                                        @endforeach
                                    </ul>

                                    <p>
                                        <a href="{{url('insider/courses/'.$course->id.'/stop')}}" class="btn btn-primary btn-sm">Перевыпуск</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endif


            @foreach($lessons as $key => $lesson)
                @if ($lesson->steps->count()!=0)
                    <div class="card-group">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5>{{$key+1}}. <a class="collection-item"
                                                           href="{{url('/insider/steps/'.$lesson->steps->first()->id)}}">{{$lesson->name}}</a>
                                        </h5>
                                    </div>
                                    @if ($user->role=='teacher')
                                        <div class="col-sm-auto">
                                            <a href="{{url('insider/lessons/'.$lesson->id.'/edit')}}"
                                               class="btn btn-success btn-sm"><i
                                                        class="icon ion-android-create"></i></a>
                                            <a href="{{url('insider/lessons/'.$lesson->id.'/export')}}"
                                               class="btn btn-success btn-sm"><i
                                                        class="icon ion-ios-cloud-download"></i></a>
                                            <a href="{{url('insider/lessons/'.$lesson->id.'/lower')}}"
                                               class="btn btn-success btn-sm"><i
                                                        class="icon ion-arrow-up-c"></i></a>
                                            <a href="{{url('insider/lessons/'.$lesson->id.'/upper')}}"
                                               class="btn btn-success btn-sm"><i
                                                        class="icon ion-arrow-down-c"></i></a>
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col">
                                        @parsedown($lesson->description)
                                    </div>
                                    @if ($user->role=='teacher' || $lesson->percent($cstudent) > 90)
                                        <div class="col-sm-auto">
                                            <img src="{{url($lesson->sticker)}}" style="max-width: 200px;"/>
                                        </div>
                                    @endif


                                </div>


                            </div>
                            @if ($lesson->start_date!=null)
                                <div class="card-footer">
                                    @if ($user->role=='teacher')
                                        <div class="collapse" id="marks{{$lesson->id}}">
                                            @foreach($students as $student)
                                                <div class="row">
                                                    <div class="col">
                                                        {{$student->name}}
                                                    </div>
                                                    <div class="col">
                                                        <div class="progress" style="margin: 5px;">
                                                            @if ($lesson->percent($student) < 40)
                                                                <div class="progress-bar progress-bar-striped bg-danger"
                                                                     role="progressbar"
                                                                     style="width: {{$lesson->percent($student)}}%"
                                                                     aria-valuenow="{{$lesson->percent($student)}}"
                                                                     aria-valuemin="0"
                                                                     aria-valuemax="100">{{$lesson->points($student)}}
                                                                    / {{$lesson->max_points($student)}}</div>

                                                            @elseif($lesson->percent($student) < 60)
                                                                <div class="progress-bar progress-bar-striped bg-warning"
                                                                     role="progressbar"
                                                                     style="width: {{$lesson->percent($student)}}%"
                                                                     aria-valuenow="{{$lesson->percent($student)}}"
                                                                     aria-valuemin="0"
                                                                     aria-valuemax="100">
                                                                    Успеваемость: {{$lesson->points($student)}}
                                                                    / {{$lesson->max_points($student)}}</div>

                                                            @else
                                                                <div class="progress-bar progress-bar-striped bg-success"
                                                                     role="progressbar"
                                                                     style="width: {{$lesson->percent($student)}}%"
                                                                     aria-valuenow="{{$lesson->percent($student)}}"
                                                                     aria-valuemin="0"
                                                                     aria-valuemax="100">
                                                                    Успеваемость: {{$lesson->points($student)}}
                                                                    / {{$lesson->max_points($student)}}</div>

                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col">
                                            <small class="text-muted"><i class="ion ion-clock"></i> Доступно
                                                с {{$lesson->start_date->format('Y-m-d')}}</small>
                                        </div>
                                        <div class="col">
                                            @if ($user->role=='student' and $lesson->max_points($cstudent)!=0)
                                                <div class="progress" style="margin: 5px;">
                                                    @if ($lesson->percent($cstudent) < 40)
                                                        <div class="progress-bar progress-bar-striped bg-danger"
                                                             role="progressbar"
                                                             style="width: {{$lesson->percent($cstudent)}}%"
                                                             aria-valuenow="{{$lesson->percent($cstudent)}}"
                                                             aria-valuemin="0"
                                                             aria-valuemax="100">{{$lesson->points($cstudent)}}
                                                            / {{$lesson->max_points($cstudent)}}</div>

                                                    @elseif($lesson->percent($cstudent) < 60)
                                                        <div class="progress-bar progress-bar-striped bg-warning"
                                                             role="progressbar"
                                                             style="width: {{$lesson->percent($cstudent)}}%"
                                                             aria-valuenow="{{$lesson->percent($cstudent)}}"
                                                             aria-valuemin="0"
                                                             aria-valuemax="100">
                                                            Успеваемость: {{$lesson->points($cstudent)}}
                                                            / {{$lesson->max_points($cstudent)}}</div>

                                                    @else
                                                        <div class="progress-bar progress-bar-striped bg-success"
                                                             role="progressbar"
                                                             style="width: {{$lesson->percent($cstudent)}}%"
                                                             aria-valuenow="{{$lesson->percent($cstudent)}}"
                                                             aria-valuemin="0"
                                                             aria-valuemax="100">
                                                            Успеваемость: {{$lesson->points($cstudent)}}
                                                            / {{$lesson->max_points($cstudent)}}</div>

                                                    @endif
                                                </div>
                                            @endif
                                            @if ($user->role=='teacher')
                                                <small class="text-muted float-right" style="margin-right: 15px;">
                                                    @foreach($students as $student)
                                                        @if ($lesson->percent($student) < 40)
                                                            <span class="badge badge-danger">&nbsp;</span>
                                                        @elseif($lesson->percent($student) < 60)
                                                            <span class="badge badge-warning">&nbsp;</span>
                                                        @else
                                                            <span class="badge badge-success">&nbsp;</span>
                                                        @endif
                                                    @endforeach

                                                    <a style="margin-left: 10px;" data-toggle="collapse"
                                                       href="#marks{{$lesson->id}}" aria-expanded="false"
                                                       aria-controls="marks{{$lesson->id}}"><i
                                                                class="ion ion-stats-bars"></i> Статистика
                                                    </a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Информация <img src="https://png.icons8.com/info/color/30/000000"></h4>
                    <p>
                        @if ($user->role=='teacher')
                            <b>Статус:</b> {{$course->state}}<br/>
                            <b>Инвайт:</b> {{$course->invite}}<br/>
                            <b>Дистанционно:</b> {{$course->remote_invite}}<br/>

                        @endif
                        @if ($course->git!=null)
                            <b><img src="https://png.icons8.com/git/color/24" title="Git" width="16" height="16"> Git
                                репозиторий:</b> <a href="{{$course->git}}">{{$course->git}}</a><br/>
                        @endif
                        @if ($course->telegram!=null)
                            <b><img src="https://png.icons8.com/telegram-app/win10/16" title="Telegram App" width="16"
                                    height="16"> Чат в телеграм:</b> <a
                                    href="{{$course->telegram}}">{{$course->telegram}}</a><br/>
                        @endif
                    </p>
                    <p>
                        <b>Преподаватели:</b>
                    </p>
                    <ul>
                        @foreach($course->teachers as $teacher)
                            <li><a class="black-link"
                                   href="{{url('/insider/profile/'.$teacher->id)}}">{{$teacher->name}}</a></li>
                        @endforeach
                    </ul>
                    <p>
                        <b>Участники:</b>
                    </p>
                    <ul>
                        @foreach($students->sortByDesc('percent') as $student)
                            <li><a class="black-link"
                                   href="{{url('/insider/profile/'.$student->id)}}">{{$student->name}}</a> <span
                                        class="badge badge-primary float-right"> {{ round($student->percent) }}
                                    % </span></li>
                        @endforeach
                    </ul>

                    @if ($user->role=='teacher')
                        <p>
                            <a href="{{url('insider/courses/'.$course->id.'/assessments')}}" class="btn btn-primary">Успеваемость</a>
                        </p>
                    @endif

                </div>
            </div>
            @if ($user->role=='student')
                <div class="card" style="margin-top: 15px;">
                    <div class="card-body">

                        <h4 class="card-title">Оценки <img src="https://png.icons8.com/medal/color/30/000000">
                            <small class="float-right"><span class="badge badge-primary">{{$cstudent->points}}
                                    / {{$cstudent->max_points}}</span></small>
                        </h4>
                        <div class="progress" style="margin-bottom: 15px;">
                            @if ($cstudent->percent < 40)
                                <div class="progress-bar progress-bar-striped bg-danger" role="progressbar"
                                     style="height: 2px;width: {{$cstudent->percent}}%"
                                     aria-valuenow="{{$cstudent->percent}}" aria-valuemin="0"
                                     aria-valuemax="100"></div>

                            @elseif($cstudent->percent < 60)
                                <div class="progress-bar progress-bar-striped bg-warning" role="progressbar"
                                     style="height: 2px;width: {{$cstudent->percent}}%"
                                     aria-valuenow="{{$cstudent->percent}}" aria-valuemin="0"
                                     aria-valuemax="100"></div>

                            @else
                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                     style="height: 2px;width: {{$cstudent->percent}}%"
                                     aria-valuenow="{{$cstudent->percent}}" aria-valuemin="0"
                                     aria-valuemax="100"></div>

                            @endif
                        </div>
                        <table class="table">
                            @foreach($steps as $step)
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
                                    @php
                                        $filtered = $task->solutions->filter(function ($value) use ($user) {
                                            return $value->user_id == $user->id && !$value->is_quiz;
                                        });
                                        $mark = $filtered->max('mark');
                                        $mark = $mark == null?0:$mark;
                                        $should_check = false;
                                        if (count($filtered)!=0 && $filtered->last()->mark==null) $should_check=true;

                                    @endphp
                                    <tr>
                                        <td>
                                            <a href="{{url('/insider/steps/'.$task->step_id.'#task'.$task->id)}}">{{$task->name}}</a>
                                        </td>

                                        @if ($should_check)
                                            <td><span class="badge badge-warning">{{$mark}}</span></td>
                                        @elseif ($mark == 0)
                                            <td><span class="badge badge-light">{{$mark}}</span></td>
                                        @else
                                            <td><span class="badge badge-primary">{{$mark}}</span></td>
                                        @endif

                                    </tr>
                                @endforeach
                            @endforeach
                        </table>
                    </div>
                </div>
            @endif
        </div>

    </div>



@endsection
