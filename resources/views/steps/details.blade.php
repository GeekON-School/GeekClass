@extends('layouts.fluid')

@section('title')
    GeekClass: "{{$step->course->name}}" - "{{$step->name}}"
@endsection

@section('tabs')

@endsection

@section('content')
    <div class="row" style="min-height: 100%; position: absolute; width: 100%;">
        <nav class="col-sm-4 col-md-3 sidebar" id="stepsSidebar">

            <ul class="nav nav-pills flex-column">
                @if (\Request::is('insider/*'))
                    <li class="nav-item">
                        <a class="nav-link" style="padding-top: 10px; padding-bottom: 10px; font-size: 150%;"
                           href="{{url('/insider/courses/'.$step->course->id)}}">
                            GeekClass </a>
                    </li>
                @endif
                @if (\Request::is('open/*'))
                    <li class="nav-item">
                        <a class="nav-link" style="padding-top: 10px; padding-bottom: 10px; font-size: 150%;"
                           href="#">
                            GeekClass </a>
                    </li>
                @endif
            </ul>
            <ul class="nav nav-pills flex-column">

                @foreach($step->lesson->steps as $lesson_step)
                    <li class="nav-item">
                        @if (\Request::is('insider/*'))
                            <a class="nav-link @if ($lesson_step->id==$step->id) active @endif"
                               href="{{url('/insider/steps/'.$lesson_step->id)}}">{{$lesson_step->name}}</a>
                        @endif
                        @if (\Request::is('open/*'))
                            <a class="nav-link @if ($lesson_step->id==$step->id) active @endif"
                               href="{{url('/open/steps/'.$lesson_step->id)}}">{{$lesson_step->name}}</a>
                        @endif
                    </li>
                @endforeach
            </ul>
            @if (\Request::is('insider/*') && $user->role=='teacher')
                <p align="center" style="margin-top: 15px;">
                    <a href="{{url('/insider/lessons/'.$step->lesson->id.'/create')}}" class="btn btn-success btn-sm">Новый
                        этап</a>
                </p>
            @endif
        </nav>

        <main role="main" class="col-sm-8 ml-sm-auto col-md-9 pt-3">
            <div style="padding: 15px;">
                @if (!$step->lesson->is_open)
                    <small><a href="{{url('/insider/courses/'.$step->course->id)}}"
                              style="font-weight: 300;">{{$step->course->name}}</a> &raquo;
                        <strong>{{$step->lesson->name}}</strong></small>
                    <h2 style="font-weight: 300;">{{$step->name}}</h2>
                @endif
                @if ($step->lesson->is_open)
                    <small>{{$step->course->name}} &raquo;
                        <strong>{{$step->lesson->name}}</strong></small>
                    <h2 style="font-weight: 300;">{{$step->name}}</h2>
                @endif
            </div>
            @php
                    @endphp
            @if (\Request::is('insider/*'))
                <div class="row">
                    <div class="col">
                        <ul class="nav nav-pills nav-fill @if (count($tasks)==0 || $one_tasker) float-right @endif"
                            id="pills-tab"
                            role="tablist">
                            @if (count($tasks)!=0 && !$zero_theory)
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" id="theory-tab" href="#theory"
                                       role="tab"
                                       aria-controls="theory" aria-expanded="true">0. Теория</a>
                                </li>
                            @endif
                            @if (!$one_tasker || !$zero_theory)
                                @foreach ($tasks as $key => $task)
                                    <li class="nav-item">
                                        <a class="nav-link " data-toggle="pill" id="tasks-tab{{$task->id}}"
                                           href="#task{{$task->id}}"
                                           aria-controls="tasks{{$task->id}}" aria-expanded="true">{{$key+1}}
                                            . {{$task->name}}
                                            @if($task->is_star) <sup>*</sup> @endif
                                            @if($task->only_class) <sup><i
                                                        class="icon ion-android-contacts"></i></sup> @endif
                                            @if($task->only_remote) <sup><i class="icon ion-at"></i></sup> @endif
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                            @if ($user->role=='teacher')
                                <li class="nav-item" style="max-width: 45px;">
                                    <a href="{{url('/insider/steps/'.$step->id.'/edit')}}"
                                       class="nav-link btn btn-success"
                                       style="padding: 8px 9px; height: 40px; margin: 0 0; margin-left: 5px; width: 40px;;"><i
                                                class="icon ion-android-create"></i></a>
                                </li>
                                <li class="nav-item" style="max-width: 45px;">
                                    <button type="button" class="nav-link btn btn-success"
                                            data-toggle="modal" data-target="#exampleModal"
                                            style="padding: 8px 9px;height: 40px; margin: 0 0; margin-left: 5px; width: 40px;;">
                                        <i class="icon ion-android-add-circle"></i>
                                    </button>
                                </li>
                                <li class="nav-item" style="max-width: 45px;">
                                    <a href="{{url('/insider/perform/'.$step->id)}}"
                                       class="nav-link btn btn-success"
                                       style="padding: 8px 9px;height: 40px; margin: 0 0; margin-left: 5px; width: 40px;"><i
                                                class="icon ion-android-desktop"></i></a>
                                </li>
                                <li class="nav-item" style="max-width: 45px;">

                                    <a class="nav-link btn btn-success"
                                       style="padding: 8px 9px;height: 40px; margin: 0 0; margin-left: 5px; width: 40px;"
                                       href="{{url('/insider/steps/'.$step->id.'/lower')}}"><i
                                                class="ion-arrow-up-c"></i></a>
                                </li>
                                <li class="nav-item" style="max-width: 45px;">
                                    <a class="nav-link btn btn-success"
                                       style="padding: 8px 9px;height: 40px; margin: 0 0; margin-left: 5px; width: 40px;"
                                       href="{{url('/insider/steps/'.$step->id.'/upper')}}"><i
                                                class="ion-arrow-down-c"></i></a>
                                </li>
                            @endif
                        </ul>

                    </div>

                </div>
            @endif


            <div class="tab-content" id="pills-tabContent" style="padding: 15px;">

                @if ($empty || !$zero_theory)
                    <div class="tab-pane fade show active" id="theory" role="tabpanel" aria-labelledby="v-theory-tab">

                        <div class="markdown">
                            @parsedown($step->theory)

                        </div>
                        @if (!$step->lesson->is_open && $user->role=='teacher' && $step->notes!='')

                            <div class="markdown">
                                <h3>Комментарий для преподавателя</h3>
                                @parsedown($step->notes)
                            </div>

                        @endif
                    </div>
                @endif
                @if (!$step->lesson->is_open)
                    @foreach ($tasks as $key => $task)
                        <div class="tab-pane fade @if (!$empty && $zero_theory) show active @endif"
                             id="task{{$task->id}}"
                             role="tabpanel"
                             aria-labelledby="tasks-tab{{$task->id}}">


                            <div class="row">
                                <div class="col">
                                    @if ($task->is_star)
                                        <div class="alert alert-success" role="alert">
                                            <strong>Это необязательная задача.</strong> За ее решение вы получите
                                            дополнительные
                                            баллы.
                                        </div>
                                    @endif

                                    <div class="card">
                                        <div class="card-header">
                                            {{$task->name}}
                                            @if (!$step->lesson->is_open && $user->role=='teacher')
                                                <a class="float-right btn btn-danger btn-sm"
                                                   href="{{url('/insider/tasks/'.$task->id.'/delete')}}"><i
                                                            class="icon ion-android-close"></i></a>
                                                <a style="margin-right: 5px;" class="float-right btn btn-success btn-sm"
                                                   href="{{url('/insider/tasks/'.$task->id.'/edit')}}"><i
                                                            class="icon ion-android-create"></i></a>
                                                <a class="float-right btn btn-default btn-sm"
                                                   href="{{url('/insider/tasks/'.$task->id.'/phantom')}}"><i
                                                            class="icon ion-ios-color-wand"></i></a>


                                                <a class="float-right btn btn-default btn-sm"
                                                   href="{{url('/insider/tasks/'.$task->id.'/right')}}"><i
                                                            class="icon ion-arrow-right-c"></i></a>
                                                <a class="float-right btn btn-default btn-sm"
                                                   href="{{url('/insider/tasks/'.$task->id.'/left')}}"><i
                                                            class="icon ion-arrow-left-c"></i></a>
                                                @if ($step->previousStep() != null)
                                                    <a class="float-right btn btn-default btn-sm"
                                                       href="{{url('/insider/tasks/'.$task->id.'/up')}}"><i
                                                                class="icon ion-arrow-up-c"></i></a>
                                                @endif
                                                @if ($step->nextStep() != null)
                                                    <a class="float-right btn btn-default btn-sm"
                                                       href="{{url('/insider/tasks/'.$task->id.'/down')}}"><i
                                                                class="icon ion-arrow-down-c"></i></a>
                                                @endif

                                            @endif

                                        </div>
                                        <div class="card-body markdown">
                                            @parsedown($task->text)

                                            <span class="badge badge-secondary">Максимальный балл: {{$task->max_mark}}</span>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            @foreach ($task->solutions as $key => $solution)
                                @if ($solution->user_id == Auth::User()->id)
                                    <div class="row" style="margin-top: 15px; margin-bottom: 15px;">

                                        <div class="col">

                                            <div class="card">
                                                <div class="card-header">
                                                    Дата сдачи: {{ $solution->submitted->format('d.M.Y H:m')}}
                                                    <div class="float-right">
                                                        @if ($solution->mark!=null)
                                                            <span class="badge badge-primary">Оценка: {{$solution->mark}}</span>
                                                            <br>
                                                        @else
                                                            <span class="badge badge-secondary">Решение еще не проверено</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    {{$solution->text}}
                                                    <br><br>
                                                    @if ($solution->mark!=null)
                                                        <p>
                                                <span class="badge badge-light">Проверено: {{$solution->checked}}
                                                    , {{$solution->teacher->name}}</span>
                                                        </p>
                                                        <p>
                                                            <span class="small">{{$solution->comment}}</span>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            <div class="row" style="margin-top: 15px; margin-bottom: 15px;">

                                <div class="col">

                                    <div class="card">
                                        <div class="card-header">
                                            Добавить решение
                                        </div>
                                        <div class="card-body">
                                            <form action="{{url('/insider/tasks/'.$task->id.'/solution')}}"
                                                  method="POST"
                                                  class="form-horizontal">
                                                {{ csrf_field() }}

                                                <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                                                    <label for="text{{$task->id}}" class="col-md-4">Текст ответа</label>

                                                    <div class="col-md-12">
                                                <textarea id="text{{$task->id}}" class="form-control"
                                                          name="text">{{old('text')}}</textarea>

                                                        <small class="text-muted">Пожалуйста, не используйте это поле
                                                            для
                                                            отправки
                                                            исходного кода. Выложите код на <a target="_blank"
                                                                                               href="https://paste.geekclass.ru">GeekPaste</a>,
                                                            <a target="_blank"
                                                               href="https://pastebin.com">pastebin</a>, <a
                                                                    target="_blank"
                                                                    href="https://gist.github.com">gist</a>
                                                            или <a target="_blank"
                                                                   href="https://paste.ofcode.org/">paste.ofcode</a>, а
                                                            затем
                                                            скопируйте ссылку сюда.<br>Для загрузки картинок и небольших
                                                            файлов можно использовать <a
                                                                    href="https://storage.geekclass.ru/"
                                                                    target="_blank">storage.geekclass.ru</a>.
                                                        </small>
                                                        @if ($errors->has('text'))
                                                            <br><span
                                                                    class="help-block error-block"><strong>{{ $errors->first('text') }}</strong></span>
                                                        @endif

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-success">Отправить</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>
                    @endforeach
                @endif


            </div>
            <p>
                @if (\Request::is('insider/*'))
                    @if ($step->previousStep() != null)
                        <a href="{{url('/insider/steps/'.$step->previousStep()->id)}}"
                           class="btn btn-success btn-sm">Назад</a>
                    @endif
                    @if ($step->nextStep() != null)
                        <a href="{{url('/insider/steps/'.$step->nextStep()->id)}}"
                           class="btn btn-success btn-sm float-right">Вперед</a>
                    @endif
                @endif
                @if (\Request::is('open/*'))
                    @if ($step->previousStep() != null)
                        <a href="{{url('/open/steps/'.$step->previousStep()->id)}}"
                           class="btn btn-success btn-sm">Назад</a>
                    @endif
                    @if ($step->nextStep() != null)
                        <a href="{{url('/open/steps/'.$step->nextStep()->id)}}"
                           class="btn btn-success btn-sm float-right">Вперед</a>
                    @endif
                @endif
            </p>

        </main>


    </div>




    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавление задачи</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('/insider/steps/'.$step->id.'/task')}}" method="POST"
                          class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4">Название</label>

                            <div class="col-md-12">
                                <input type="text" name="name" class="form-control" id="name"/>
                                @if ($errors->has('name'))
                                    <span class="help-block error-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('max_mark') ? ' has-error' : '' }}">
                            <label for="max_mark" class="col-md-4">Максимальный балл</label>

                            <div class="col-md-12">
                                <input type="text" name="max_mark" class="form-control" id="max_mark"/>
                                @if ($errors->has('max_mark'))
                                    <span class="help-block error-block">
                                        <strong>{{ $errors->first('max_mark') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                            <label for="text" class="col-md-4">Текст вопроса</label>

                            <div class="col-md-12">
                                                <textarea id="text" class="form-control"
                                                          name="text">{{old('text')}}</textarea>

                                @if ($errors->has('text'))
                                    <span class="help-block error-block">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="is_star">Дополнительное</label>
                            <input type="checkbox" id="is_star" name="is_star" value="on"/>
                        </div>
                        <div class="form-group">
                            <label for="only_class">Только для очной формы</label>
                            <input type="checkbox" id="only_class" name="only_class" value="on"/>
                        </div>
                        <div class="form-group">
                            <label for="only_remote">Только для заочной формы</label>
                            <input type="checkbox" id="only_remote" name="only_remote" value="on"/>
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

    <script>

        $('blockquote').addClass('bd-callout bd-callout-info')

        var simplemde_task = new SimpleMDE({
            spellChecker: false,
            element: document.getElementById("text")
        });

        $('table').addClass('table table-striped');
    </script>




@endsection
