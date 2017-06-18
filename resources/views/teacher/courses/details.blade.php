@extends('layouts.app')

@section('content')
    <h3 style="padding-bottom: 10px;">
        <a href="{{url('/teacher')}}"><span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span></a>
        Курс "{{$course->name}}"
        <span class="pull-right small">
                <a href="{{url('/teacher/courses/'.$course->id.'/edit')}}" class="btn btn-primary btn-sm">Изменить</a>
            @if ($course->state=="draft")
                <a href="{{url('/teacher/courses/'.$course->id.'/start')}}"
                   class="btn btn-success btn-sm">Запустить</a>
            @elseif ($course->state=="started")
                <a href="{{url('/teacher/courses/'.$course->id.'/stop')}}"
                   class="btn btn-danger btn-sm">Завершить</a>
            @endif
            </span>
    </h3>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">

                <div class="panel-body">
                    <h4>Описание</h4>
                    @parsedown($course->description)
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h4 align="center">Журнал</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h4 align="center">Достижения</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <p>
                                <b>Статус:</b> {{$course->state}}<br/>
                                <b>Инвайт:</b> {{$course->invite}}<br/>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h3 style="padding-bottom: 10px;">Тематический план
        <span class="pull-right small">
                <a href="{{url('/teacher/courses/'.$course->id.'/create')}}" class="btn btn-primary btn-sm">Добавить тему</a>
            </span>
    </h3>
    <div class="row">
        @foreach($course->steps as $step)
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a href="{{url('/teacher/lessons/'.$step->id)}}">{{$step->name}}</a>
                        <span class="pull-right"><a href="{{url('/teacher/lessons/'.$course->id.'/delete')}}"
                                                    class="btn btn-danger btn-sm">Удалить</a></span>
                    </div>
                </div>

            </div>
        @endforeach


    </div>
@endsection
