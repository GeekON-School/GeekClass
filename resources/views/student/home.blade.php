@extends('layouts.app')

@section('content')

    <h3 style="padding-bottom: 10px; ">Курсы
    </h3>

    <div class="row">

        @foreach($courses as $course)
            <div class="col-md-4">
                <div class="panel panel-default course-panel">
                    <div class="panel-body">
                        <div class="media">
                            <div class="media-left media-top">
                                <a href="{{url('student/courses/'.$course->id)}}">
                                    <img style="height: 70px;" class="img-rounded media-object"
                                         src="{{url('media/'.$course->image)}}" alt="...">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4><a href="{{url('student/courses/'.$course->id)}}">{{$course->name}}</a></h4>
                                <p class="blue">{{$course->state}}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

    <form class="form-inline" method="GET" action="{{url('/student/invite')}}">
        <div class="form-group">
            <label for="invite">Инвайт</label>
            <input type="text" class="form-control" id="invite" name="invite">
        </div>
        <button type="submit" class="btn btn-success btn-sm">Добавить</button>
    </form>

    <h3 style="padding-bottom: 10px; ">Ближайшие события
        <span class="small">
                <a href="{{url('student/calendar')}}">Календарь</a>
            </span>
    </h3>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default course-panel">
                <div class="panel-body">
                    <h4>Событие</h4>
                    <p class="blue">Информация о нем</p>
                </div>
            </div>

        </div>
    </div>

    <h3 style="padding-bottom: 10px; ">Последние достижения
        <span class="small">
                <a href="{{url('student/calendar')}}">Все достижения</a>
            </span>
    </h3>

    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default course-panel">
                <div class="panel-body">
                    <h4>Ачивка</h4>
                    <p class="blue">Описание</p>
                </div>
            </div>

        </div>
    </div>
@endsection
