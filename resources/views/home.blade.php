@extends('layouts.app')

@section('title')
    GeekClass
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <h2>Курсы</h2>
        </div>
        <div class="col"><a class="float-right btn btn-success btn-sm" href="{{url('/insider/courses/create/')}}">Создать</a>
        </div>
    </div>

    <div class="row" style="margin-top: 15px;">
        @foreach($courses as $course)
            <div class="col-md-4">
                <div class="card" style="width: 100%;">
                    <!--<img class="card-img-top" src="..." alt="Card image cap">-->
                    <div class="card-body">
                        <h4 class="card-title">{{$course->name}}</h4>
                        <p class="card-text">{{$course->description}}</p>
                        <a href="{{url('insider/courses/'.$course->id)}}" class="btn btn-primary">Страница курса</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
