@extends('layouts.app')

@section('title')
    GeekClass: "{{$step->course->name}}" - "{{$step->name}}"
@endsection

@section('tabs')
    <div class="nav-content">
        <ul class="tabs tabs-transparent">
            <li class="tab"><a class="active" href="#test1">Теория</a></li>
            <li class="tab"><a href="#test2">Тестирование</a></li>
            <li class="tab"><a href="#test3">Домашнее задание</a></li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="fixed-action-btn horizontal">
        <a href="{{url('/teacher/lessons/'.$step->id.'/edit')}}"
           class="btn-floating btn-large waves-effect waves-light red"><i
                    class="material-icons">edit</i></a>
    </div>
    <div id="test1">
        <div class="row">
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Описание</span>
                        @parsedown($step->description)
                    </div>
                </div>
            </div>

            <div class="col s12 m6">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Комментарии для преподавателя</span>
                        @parsedown($step->notes)
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Теоретический материал</span>
                        @parsedown($step->theory)
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div id="test2">

        <h3 style="padding-bottom: 10px;">Вопросы для самоконтроля</h3>

        <div class="row">
            @foreach ($step->questions as $question)
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            @parsedown($question->text)
                            <ol>
                                @foreach ($question->variants as $key => $variant)
                                    <li style="@if ($variant->is_correct) color: green; @endif "> {{$variant->text}}</li>
                                @endforeach
                            </ol>
                            <span class="pull-right">
                                <a href="{{url('/teacher/questions/'.$question->id.'/delete')}}" class="btn btn-danger">Удалить</a>

                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <form action="{{url('/teacher/lessons/'.$step->id.'/question')}}" method="POST"
                              class="form-horizontal">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
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

                            <div class="form-group{{ $errors->has('variants') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    1.&nbsp;<input type="text" style="width: 80%; display: inline-block;"
                                                   class="form-control" name="variants[0][text]"/>
                                    <input type="checkbox" value="on" name="variants[0][is_correct]"
                                           style="display: inline-block;"><br>
                                    2.&nbsp;<input type="text" style="width: 80%; display: inline-block;"
                                                   class="form-control" name="variants[1][text]"/>
                                    <input type="checkbox" value="on" name="variants[1][is_correct]"
                                           style="display: inline-block;"><br>
                                    3.&nbsp;<input type="text" style="width: 80%; display: inline-block;"
                                                   class="form-control" name="variants[2][text]"/>
                                    <input type="checkbox" value="on" name="variants[2][is_correct]"
                                           style="display: inline-block;"><br>
                                    4.&nbsp;<input type="text" style="width: 80%; display: inline-block;"
                                                   class="form-control" name="variants[3][text]"/>
                                    <input type="checkbox" value="on" name="variants[3][is_correct]"
                                           style="display: inline-block;"><br>
                                    @if ($errors->has('variants'))
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
    <div id="test3">

        <h3 style="padding-bottom: 10px;">Домашнее задание</h3>

        <div class="row">
            @foreach ($step->tasks as $task)
                <div class="col-md-12">
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <h4>{{$task->name}}</h4>
                            @parsedown($task->text)
                            <span class="pull-right">
                                <a href="{{url('/teacher/tasks/'.$task->id.'/delete')}}"
                                   class="btn btn-danger">Удалить</a>
                                </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">


                        <form action="{{url('/teacher/lessons/'.$step->id.'/task')}}" method="POST"
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
@endsection
