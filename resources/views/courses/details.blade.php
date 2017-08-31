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
    <div class="row">
        <div class="col">
            <h2>{{$course->name}}</h2>
            <p>{{$course->description}}</p>
        </div>
        <div class="col">
            <div class="float-right">
                <a href="{{url('/insider/courses/'.$course->id.'/create')}}" class="btn btn-primary btn-sm">Новая
                    тема</a>
                <a href="{{url('/insider/courses/'.$course->id.'/edit')}}" class="btn btn-primary btn-sm">Изменить</a>
                @if ($course->state=="draft")
                    <a href="{{url('/insider/courses/'.$course->id.'/start')}}"
                       class="btn btn-success btn-sm">Запустить</a>
                @elseif ($course->state=="started")
                    <a href="{{url('/insider/courses/'.$course->id.'/stop')}}"
                       class="btn btn-danger btn-sm">Завершить</a>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            @foreach($course->steps as $key => $step)
                <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <h5>{{$key+1}}. <a class="collection-item"
                                               href="{{url('/insider/lessons/'.$step->id)}}">{{$step->name}}</a></h5>
                            @parsedown($step->description)
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Доступно с {{$step->start_date}}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <span class="card-title">Информация</span>
                    <p>
                        <b>Статус:</b> {{$course->state}}<br/>
                        <b>Инвайт:</b> {{$course->invite}}<br/>
                    </p>
                </div>
            </div>
        </div>

    </div>



@endsection
