@extends('layouts.app')

@section('title')
    GeekClass: "{{$course->name}}"
@endsection

@section('tabs')
    <div class="nav-content">
        <ul class="tabs tabs-transparent">
            <li class="tab"><a class="active" href="#test1">Страница курса</a></li>
            <li class="tab"><a href="#test2">Ведомость</a></li>
            <li class="tab"><a href="#test3">Достижения</a></li>
        </ul>
    </div>
@endsection

@section('content')

    <div id="test1" class="col s12" style="padding-top: 20px;">
        <div class="row">
            <div class="col s12 m8">
                <div class="card blue darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Описание</span>
                        @parsedown($course->description)
                    </div>
                    <div class="card-action">
                        <a href="{{url('/teacher/courses/'.$course->id.'/edit')}}" class="btn btn-primary btn-sm">Изменить</a>
                        @if ($course->state=="draft")
                            <a href="{{url('/teacher/courses/'.$course->id.'/start')}}"
                               class="btn btn-success btn-sm">Запустить</a>
                        @elseif ($course->state=="started")
                            <a href="{{url('/teacher/courses/'.$course->id.'/stop')}}"
                               class="btn btn-danger btn-sm">Завершить</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Информация</span>
                        <p>
                            <b>Статус:</b> {{$course->state}}<br/>
                            <b>Инвайт:</b> {{$course->invite}}<br/>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12 m12">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Тематический план</span>
                        <div class="fixed-action-btn horizontal">
                            <a href="{{url('/teacher/courses/'.$course->id.'/create')}}"
                               class="btn-floating btn-large waves-effect waves-light red"><i
                                        class="material-icons">add</i></a>
                        </div>
                        <ul class="collection">
                            @foreach($course->steps as $step)
                                <a class="collection-item"
                                            href="{{url('/teacher/lessons/'.$step->id)}}">{{$step->name}}</a>
                                    <!--<span class="pull-right"><a
                                                href="{{url('/teacher/lessons/'.$course->id.'/delete')}}"
                                                class="btn btn-danger btn-sm">Удалить</a></span>-->
                            @endforeach


                        </ul>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="test2" class="col s12">Test 2</div>
    <div id="test3" class="col s12">Test 3</div>

@endsection
