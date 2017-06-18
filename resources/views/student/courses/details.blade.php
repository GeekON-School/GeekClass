@extends('layouts.app')

@section('content')
    <h3 style="padding-bottom: 10px;">
        <a href="{{url('/student')}}"><span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span></a>
        Курс "{{$course->name}}"
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
    <h3 style="padding-bottom: 10px;">Темы
    </h3>
    <div class="row">
        @foreach($course->steps as $step)
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a href="{{url('/student/lessons/'.$step->id)}}">{{$step->name}}</a>
                    </div>
                </div>

            </div>
        @endforeach


    </div>
@endsection
