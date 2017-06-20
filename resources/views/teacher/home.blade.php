@extends('layouts.app')

@section('title')
    GeekClass
@endsection

@section('content')
    <div class="mdl-layout">
        <div class="mdl-grid">
            <h2>Курсы</h2>
        </div>
        <div class="fixed-action-btn horizontal">
        <a href="{{url('/teacher/courses/create/')}}" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
        </div>
        <div class="row">
            @foreach($courses as $course)
                <div class="col s12 m4">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">{{$course->name}}</span>
                            @parsedown($course->description)
                        </div>
                        <div class="card-action">
                            <a href="{{url('teacher/courses/'.$course->id)}}">Страница курса</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
