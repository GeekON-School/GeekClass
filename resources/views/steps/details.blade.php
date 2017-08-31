@extends('layouts.app')

@section('title')
    GeekClass: "{{$step->course->name}}" - "{{$step->name}}"
@endsection

@section('tabs')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h2><span style="font-weight: 200;">{{$step->course->name}} - </span>{{$step->name}}</h2>
        </div>
        <div class="col-md-4">
            <a href="{{url('/insider/lessons/'.$step->id.'/edit')}}"
               class="float-right btn btn-sm btn-success">Редактировать</a>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="theory-tab" data-toggle="pill" href="#theory" role="tab"
                       aria-controls="theory" aria-expanded="true">Теория</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tasks-tab" data-toggle="pill" href="#tasks" role="tab"
                       aria-controls="tasks" aria-expanded="true">Задачи</a>
                </li>

            </ul>
        </div>


    </div>
    <div class="tab-content" id="pills-tabContent" style="margin: 15px 0;">
        <div class="tab-pane fade show active" id="theory" role="tabpanel" aria-labelledby="v-theory-tab">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body markdown">
                            @parsedown($step->theory)
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tasks" role="tabpanel" aria-labelledby="tasks-tab">



            <div class="row">
                <div class="col">
                    @foreach ($step->tasks as $task)
                    <div class="card">
                        <div class="card-header">
                            {{$task->name}}
                            <a class="float-right btn btn-danger btn-sm" href="{{url('/teacher/tasks/'.$task->id.'/delete')}}">Удалить</a>
                            <a style="margin-right: 5px;" class="float-right btn btn-success btn-sm" href="{{url('/teacher/tasks/'.$task->id.'/edit')}}">Редактировать</a>
                        </div>
                        <div class="card-body markdown">
                            @parsedown($task->text)
                        </div>
                    </div>
                    @endforeach
                </div>



            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">

                        <div class="panel-body">


                            <form action="{{url('/insider/lessons/'.$step->id.'/task')}}" method="POST"
                                  class="form-horizontal">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4">Название</label>

                                    <div class="col-md-12">
                                        <input type="text" name="name" class="form-control" id="name"/>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                                    <label for="text" class="col-md-4">Текст вопроса</label>

                                    <div class="col-md-12">
                                        <textarea id="text" class="form-control" name="text">{{old('text')}}</textarea>

                                        @if ($errors->has('text'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success">Создать</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>




@endsection
