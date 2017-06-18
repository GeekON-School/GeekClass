@extends('layouts.app')

@section('content')
    <h3 style="padding-bottom: 10px;">
        <a href="{{url('/teacher/courses/'.$step->course->id)}}"><span class="glyphicon glyphicon-triangle-left"
                                                                       aria-hidden="true"></span></a>
        {{$step->course->name}}: "{{$step->name}}"
        <span class="pull-right small">
                <a href="{{url('/teacher/lessons/'.$step->id.'/edit')}}"
                   class="btn btn-primary btn-sm">Изменить</a>
            </span>
    </h3>


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
@endsection
