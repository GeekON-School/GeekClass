@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($courses as $course)
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="media">
                                <div class="media-left media-top">
                                    <a href="{{url('/courses/'.$course->id)}}">
                                        <img style="height: 70px;" class="img-rounded media-object" src="{{url('media/'.$course->image)}}" alt="...">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h3 align="center"><a href="{{url('/courses/'.$course->id)}}">{{$course->name}}</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
            <a href="{{url('/courses/create/')}}" class="btn btn-success">Добавить</a>

    </div>
@endsection
