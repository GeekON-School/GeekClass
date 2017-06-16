@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>{{$step->course->name}}: "{{$step->name}}" <a href="{{url('/lessons/'.$step->id.'/edit')}}" class="btn btn-primary">Изменить</a></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Описание</div>

                    <div class="panel-body">
                        @parsedown($step->description)
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Комментарии для преподавателя</div>

                    <div class="panel-body">

                        @parsedown($step->notes)

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Теоретический материал</div>

                    <div class="panel-body">
                        @parsedown($step->theory)


                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Проверь себя</div>

                    <div class="panel-body">
                        тут будут тесты


                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Задачи</div>

                    <div class="panel-body">
                        тут будут задачи


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
