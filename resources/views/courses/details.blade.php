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

                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Действия
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{url('/insider/courses/'.$course->id.'/create?chapter='.$chapter->id)}}"
                               class="dropdown-item"><i
                                        class="icon ion-compose"></i> Добавить урок</a>
                            <a href="{{url('/insider/courses/'.$course->id.'/chapter')}}" class="dropdown-item"><i
                                        class="icon ion-plus"></i> Добавить главу</a>
                            <a href="{{url('/insider/courses/'.$course->id.'/edit')}}"
                               class="dropdown-item"><i
                                        class="icon ion-android-create"></i> Изменить курс</a>
                            @if ($course->state=="draft")
                                <a href="{{url('/insider/courses/'.$course->id.'/start')}}"
                                   class="dropdown-item"><i
                                            class="icon ion-power"></i> Запустить курс</a>
                            @elseif ($course->state=="started")
                                <a href="{{url('/insider/courses/'.$course->id.'/stop')}}"
                                   class="dropdown-item"><i
                                            class="icon ion-stop"></i> Завершить курс</a>
                            @endif
                        </div>
                    </div>


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
                                    <a data-toggle="collapse" href="#certs" role="button" aria-expanded="false"
                                       aria-controls="certs"><strong>Сертификаты</strong></a>
                                    <a href="{{url('insider/courses/'.$course->id.'/stop')}}"
                                       class="float-right btn btn-success btn-sm">Перевыпуск</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="collapse" id="certs">
                                        <p>
                                        <ul>
                                            @foreach($marks as $mark)
                                                @if ($mark->cert_link!= null)
                                                    <li><a target="_blank"
                                                           href="{{$mark->cert_link}}">{{$mark->user->name}} <span
                                                                    class="float-right badge badge-pill badge-success">{{$mark->mark}}</span></a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endif

            @if ($course->state=="started")

                <div class="card" style="padding-top: 10px;">
                    <div id="pulse" style="width:100%; height: 100px; margin-bottom: 10px;"></div>
                </div>


                <script>
                    var data = [
                        {
                            x: {!! $pulse_keys !!},
                            y: {!!$pulse_values!!},
                            type: 'scatter'
                        }
                    ];

                    Plotly.newPlot('pulse', data, {
                        xaxis: {
                            autotick: true,

                            zeroline: false,
                            showline: false,
                            showgrid: false

                        }, yaxis: {
                            showgrid: false,
                            zeroline: false,
                            showline: false
                        }, margin: {
                            l: 15,
                            r: 0,
                            b: 24,
                            t: 3,
                            pad: 0
                        },
                    }, {staticPlot: false, displayModeBar: false});
                </script>
            @endif

            @foreach($chapter->lessons as $key => $lesson)
                @if ($lesson->steps->count()!=0)
                    <div class="card-group">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        @if ($lesson->isAvailable($course) or $user->role=='teacher')
                                            <h5>{{$key+1}}. <a class="collection-item"
                                                               href="{{url('/insider/courses/'.$course->id.'/steps/'.$lesson->steps->first()->id)}}">{{$lesson->name}}</a>
                                            </h5>
                                        @else
                                            <h5>{{$key+1}}. <a class="collection-item text-muted"
                                                               href="#">{{$lesson->name}}</a>
                                            </h5>
                                        @endif
                                    </div>
                                    @if ($user->role=='teacher')
                                        <div class="col-sm-auto">
                                            <a href="{{url('insider/courses/'.$course->id.'/lessons/'.$lesson->id.'/edit')}}"
                                               class="btn btn-success btn-sm"><i
                                                        class="icon ion-android-create"></i></a>
                                            <a href="{{url('insider/courses/'.$course->id.'/lessons/'.$lesson->id.'/export')}}"
                                               class="btn btn-success btn-sm"><i
                                                        class="icon ion-ios-cloud-download"></i></a>
                                            <a href="{{url('insider/courses/'.$course->id.'/lessons/'.$lesson->id.'/lower?chapter='.$chapter->id)}}"
                                               class="btn btn-success btn-sm"><i
                                                        class="icon ion-arrow-up-c"></i></a>
                                            <a href="{{url('insider/courses/'.$course->id.'/lessons/'.$lesson->id.'/upper?chapter='.$chapter->id)}}"
                                               class="btn btn-success btn-sm"><i
                                                        class="icon ion-arrow-down-c"></i></a>
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col">
                                        @parsedown($lesson->description)

                                        @if (count($lesson->prerequisites)!=0)
                                            <p>
                                                <small class="text-muted">Нужно уметь:</small>
                                                <br>
                                                @foreach($lesson->prerequisites as $prerequisite)
                                                    @if (!$user->checkPrerequisite($prerequisite))
                                                        <a tabindex="0" data-toggle="popover" data-trigger="focus"
                                                           title="{{$prerequisite->title}}" data-html="true"
                                                           data-content="<small>{{$prerequisite->getParentLine()}}</small> {{$prerequisite->getRelatedLessonsHTML()}}">
                                                            <span class="badge @if ($user->role=='teacher') badge-secondary @else badge-danger @endif">{{$prerequisite->title}}</span>
                                                        </a>
                                                    @else
                                                        <span class="badge badge-success">{{$prerequisite->title}}</span>
                                                    @endif
                                                @endforeach
                                            </p>
                                        @endif

                                        <p>
                                            <small class="text-muted">Результаты:</small>
                                            <br>
                                            @foreach($lesson->getConsequences() as $consequence)
                                                @if (!$user->checkPrerequisite($consequence))
                                                    <span class="badge badge-secondary">{{$consequence->title}}</span>
                                                @else
                                                    <span class="badge badge-success">{{$consequence->title}}</span>
                                                @endif
                                            @endforeach
                                        </p>
                                    </div>
                                    @if ($user->role!='teacher' and $lesson->percent($cstudent) > 90)
                                        <div class="col-sm-auto">
                                            <img src="{{url($lesson->sticker)}}" style="max-width: 200px;"/>
                                        </div>
                                    @endif


                                </div>
                            </div>
                            @if ($lesson->getStartDate($course)!=null)
                                <div class="card-footer">
                                    @if ($user->role=='teacher')
                                        <div class="collapse" id="marks{{$lesson->id}}">
                                            @foreach($students as $student)
                                                <div class="row">
                                                    <div class="col">
                                                        {{$student->name}} @if (!$lesson->isAvailableForUser($course, $student))
                                                            <strong><span style="color: red;">!!!</span></strong> @endif
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
                                                с {{$lesson->getStartDate($course)->format('Y-m-d')}}</small>
                                        </div>
                                        <div class="col">
                                            @if ($user->role=='student' and $lesson->max_points($cstudent)!=0 and $lesson->isAvailable($course))
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
                                            @if ($user->role=='student' and !$lesson->isAvailable($course))
                                                <span class="badge badge-danger float-right" style="margin: 3px;">Не выполнены требования</span>
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
            @if ($course->program->chapters->count()>1)
                <ul style="margin-bottom: 15px;" class="list-group">

                    @foreach($course->program->chapters as $current_chapter)
                        @if ($user->role == 'teacher' or $current_chapter->isStarted($course))
                            <li class="list-group-item @if ($current_chapter->id == $chapter->id)  list-group-item-success @endif"
                                style="border-radius: 0 !important;"><a
                                        href="{{url('/insider/courses/'.$course->id.'?chapter='.$current_chapter->id)}}">{{$current_chapter->name}}
                                    @if ($user->role=='teacher' and $current_chapter->isStarted($course))
                                        <span class="badge badge-primary"> {{ round($current_chapter->getStudentsPercent($course)) }}
                                            % </span>
                                    @endif
                                    @if ($user->role=='student')
                                        <span class="badge badge-primary"> {{ round($current_chapter->getStudentPercent($user)) }}
                                            % </span>
                                    @endif
                                </a>

                                @if ($user->role=='teacher')
                                    <span class="float-right">
                                <a href="{{url('insider/courses/'.$course->id.'/chapters/'.$current_chapter->id.'/edit')}}"
                                   class="btn btn-success btn-sm"><i
                                            class="icon ion-android-create"></i></a>
                                <a href="{{url('insider/courses/'.$course->id.'/chapters/'.$current_chapter->id.'/lower')}}"
                                   class="btn btn-success btn-sm"><i
                                            class="icon ion-arrow-up-c"></i></a>
                                <a href="{{url('insider/courses/'.$course->id.'/chapters/'.$current_chapter->id.'/upper')}}"
                                   class="btn btn-success btn-sm"><i
                                            class="icon ion-arrow-down-c"></i></a>
                            </span>
                                    <p class="small" style="margin-bottom: 0;">{{$current_chapter->description}}</p>
                                @else
                                    @if ($current_chapter->isDone($course) and $user->role!='teacher')
                                        <span class="float-right">
                                        <i class="icon ion-checkmark-circled" style="color:green;"></i> <span
                                                    style="color: green;">выполнено</span>
                                        </span>
                                    @endif
                                @endif
                            </li>
                        @endif
                    @endforeach

                </ul>
            @endif


            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Информация <img src="https://png.icons8.com/info/color/30/000000"></h4>
                    <p>
                        @if ($user->role=='teacher')
                            <b>Статус:</b> {{$course->state}}<br/>
                            <b>Инвайт:</b> {{$course->invite}}<br/>

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
                        <b>Студенты:</b>
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

                        <div id="histogram"></div>

                        <script>
                                    @php
                                        $points = [];
                                        foreach ($students as $student)
                                        {
                                            array_push($points, $student->percent);
                                        }
                                    @endphp
                            var x = [{{implode(',',$points)}}];

                            var trace = {
                                x: x,
                                type: 'histogram',
                                autobinx: false,
                                marker: {
                                    color: "rgba(100, 200, 102, 0.7)",
                                    line: {
                                        color: "rgba(100, 200, 102, 1)",
                                        width: 1
                                    }
                                },
                                opacity: 0.75,
                                xbins: {
                                    end: 110,
                                    size: 15,
                                    start: 0

                                }
                            };

                            var data = [trace];
                            Plotly.newPlot('histogram', data);
                        </script>

                        <p>
                            <a href="{{url('insider/courses/'.$course->id.'/assessments')}}"
                               class="btn btn-success btn-sm">Успеваемость</a>
                            <a href="{{url('insider/courses/'.$course->id.'/report')}}"
                               class="btn btn-success btn-sm">Отчет</a>
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
                                        if ($task->answer != null) continue;
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
                                            @if ($task->step->lesson->isAvailable($course))
                                                <a href="{{url('/insider/courses/'.$course->id.'/steps/'.$task->step_id.'#task'.$task->id)}}">{{$task->name}} @if ($task->is_star)
                                                        (*)@endif</a>
                                            @else
                                                <a href="#" class="text-muted">{{$task->name}} @if ($task->is_star)
                                                        (*)@endif</a>
                                            @endif
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
        <script>
            $(function () {
                $('[data-toggle="popover"]').popover()
            });
            $('.popover-dismiss').popover({
                trigger: 'focus'
            });
        </script>

    </div>



@endsection
