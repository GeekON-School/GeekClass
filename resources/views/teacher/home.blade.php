@extends('layouts.app')

@section('content')
    <h3 style="padding-bottomc: 10px; ">Курсы
        <span class="pull-right small">
                <a href="{{url('/teacher/courses/create/')}}" class="btn btn-success btn-sm">Добавить</a>
            </span>
    </h3>
    <div class="row">

        @foreach($courses as $course)
            <div class="col-md-4">
                <div class="panel panel-default course-panel">
                    <div class="panel-body">
                        <div class="media">
                            <div class="media-left media-top">
                                <a href="{{url('teacher/courses/'.$course->id)}}">
                                    <img style="height: 70px;" class="img-rounded media-object"
                                         src="{{url('media/'.$course->image)}}" alt="...">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4><a href="{{url('teacher/courses/'.$course->id)}}">{{$course->name}}</a></h4>
                                <p class="blue">{{$course->state}}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
@endsection
