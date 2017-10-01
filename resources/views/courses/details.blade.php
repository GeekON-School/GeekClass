@extends('layouts.app')

@section('title')
    GeekClass: "{{$course->name}}"
@endsection

@section('tabs')

@endsection

@section('content')
    <div class="row">
        <div class="col">
            <h2>{{$course->name}}</h2>
            <p>{{$course->description}}</p>
        </div>
        @if ($user->role=='teacher')
            <div class="col">
                <div class="float-right">
                    <a href="{{url('/insider/courses/'.$course->id.'/create')}}" class="btn btn-primary btn-sm">Новая
                        тема</a>
                    <a href="{{url('/insider/courses/'.$course->id.'/edit')}}"
                       class="btn btn-primary btn-sm">Изменить</a>
                    @if ($course->state=="draft")
                        <a href="{{url('/insider/courses/'.$course->id.'/start')}}"
                           class="btn btn-success btn-sm">Запустить</a>
                    @elseif ($course->state=="started")
                        <a href="{{url('/insider/courses/'.$course->id.'/stop')}}"
                           class="btn btn-danger btn-sm">Завершить</a>
                    @endif
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-8">
            @if ($user->role=='student')
                <div class="progress" style="margin-bottom: 15px;">
                    @if ($percent < 30)
                        <div class="progress-bar progress-bar-striped bg-danger" role="progressbar"
                             style="width: {{$percent}}%" aria-valuenow="{{$percent}}" aria-valuemin="0"
                             aria-valuemax="100">{{$points}} / {{$max_points}}</div>

                    @elseif($percent < 50)
                        <div class="progress-bar progress-bar-striped bg-warning" role="progressbar"
                             style="width: {{$percent}}%" aria-valuenow="{{$percent}}" aria-valuemin="0"
                             aria-valuemax="100">Успеваемость: {{$points}} / {{$max_points}}</div>

                    @else
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                             style="width: {{$percent}}%" aria-valuenow="{{$percent}}" aria-valuemin="0"
                             aria-valuemax="100">Успеваемость: {{$points}} / {{$max_points}}</div>

                    @endif
                </div>
            @endif
            @foreach($steps as $key => $step)

                <div class="card-group">
                    <div class="card">
                        <div class="card-body">

                                <h5>{{$key+1}}. <a class="collection-item"
                                                   href="{{url('/insider/lessons/'.$step->id)}}">{{$step->name}}</a>
                                </h5>
                            @parsedown($step->description)
                        </div>
                        @if ($step->start_date!=null)
                            <div class="card-footer">
                                <small class="text-muted">Доступно с {{$step->start_date->format('Y-m-d')}}</small>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Информация</h4>
                    <p>
                        @if ($user->role=='teacher')
                            <b>Статус:</b> {{$course->state}}<br/>
                            <b>Инвайт:</b> {{$course->invite}}<br/>

                        @endif
                        @if ($course->git!=null)
                            <b>Git репозиторий:</b> <a href="{{$course->git}}">{{$course->git}}</a><br/>
                        @endif
                        @if ($course->telegram!=null)
                            <b>Чат в телеграм:</b> <a href="{{$course->telegram}}">{{$course->telegram}}</a><br/>
                        @endif
                        <b>Преподаватели:</b><br/>
                    <ul>
                        @foreach($course->teachers as $teacher)
                            <li>{{$teacher->name}}</li>
                        @endforeach
                    </ul>
                    <b>Участники:</b><br/>
                    <ul>
                        @foreach($course->students as $student)
                            <li>{{$student->name}} @if ($user->role=='teacher') <span class="badge badge-primary"> {{ round($student->percent) }} % </span> @endif</li>
                        @endforeach
                    </ul>
                    </p>
                    @if ($user->role=='teacher')
                        <a href="{{url('insider/courses/'.$course->id.'/assessments')}}" class="btn btn-primary">Успеваемость</a>
                    @endif
                </div>
            </div>
            @if ($user->role=='student')
                <div class="card" style="margin-top: 15px;">
                    <div class="card-body">
                        <h4 class="card-title">Оценки
                            <small class="float-right"><span class="badge badge-primary">{{$points}}
                                    / {{$max_points}}</span></small>
                        </h4>
                        <table class="table">
                            @foreach($steps as $step)
                                <tr>
                                    <th colspan="2">{{$step->name}}</th>
                                </tr>
                                @php
                                    if ($user->is_remote)
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
                                            return $value->user_id == $user->id;
                                        });
                                        $mark = $filtered->max('mark');
                                        $mark = $mark == null?0:$mark;
                                        $should_check = false;
                                        if (count($filtered)!=0 && $filtered->last()->mark==null) $should_check=true;

                                    @endphp
                                    <tr>
                                        <td>
                                            <a href="{{url('/insider/lessons/'.$task->step_id.'#task'.$task->id)}}">{{$task->name}}</a>
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
