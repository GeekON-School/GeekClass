@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Курс "{{$course->name}}"</div>

                    <div class="panel-body">
                        <p>@parsedown($course->description)</p>
                        <p><a href="{{url('/courses/'.$course->id.'/create')}}" class="btn btn-success">Добавить
                                тему</a>
                            <a href="{{url('/courses/'.$course->id.'/edit')}}" class="btn btn-primary">Изменить</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($course->steps as $step)
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <a href="{{url('/lessons/'.$step->id)}}">{{$step->name}}</a>
                        </div>
                    </div>

                </div>
            @endforeach


        </div>
    </div>
@endsection
