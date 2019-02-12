@extends('layouts.app')

@section('title')
    GeekClass: "{{$course->name}}"
@endsection

@section('tabs')

@endsection



@section('content')
    <div class="row">
        <div class="col">
            <h2 style="font-weight: 300;">{{$course->name}}</h2>
            <p>{{$course->description}}</p>
        </div>
        @if ($user->role=='teacher')
            <div class="col">
                <div class="float-right">

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addLessonModal">
                        Launch demo modal
                    </button>


                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Действия
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{url('/insider/courses/'.$course->id.'/edit')}}"
                               class="dropdown-item"><i
                                        class="icon ion-android-create"></i> Изменить курс</a>
                            @if ($course->state=="draft")
                                <a href="{{url('/insider/courses/'.$course->id.'/start')}}"
                                   class="dropdown-item"><i
                                            class="icon ion-power"></i> Запустить курс</a>
                            @elseif ($course->state=="started")
                                <a href="{{url('/insider/courses/'.$course->id.'/stop')}}"
                                   class="dropdown-item"><i
                                            class="icon ion-stop"></i> Завершить курс</a>
                            @endif
                        </div>
                    </div>


                </div>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-8">

            @if ($course->state=="ended" and $user->role=='teacher')
                <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <a data-toggle="collapse" href="#certs" role="button" aria-expanded="false"
                                       aria-controls="certs"><strong>Сертификаты</strong></a>
                                    <a href="{{url('insider/courses/'.$course->id.'/stop')}}"
                                       class="float-right btn btn-success btn-sm">Перевыпуск</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="collapse" id="certs">
                                        <p>
                                        <ul>
                                            @foreach($marks as $mark)
                                                @if ($mark->cert_link!= null)
                                                    <li><a target="_blank"
                                                           href="{{$mark->cert_link}}">{{$mark->user->name}} <span
                                                                    class="float-right badge badge-pill badge-success">{{$mark->mark}}</span></a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endif


            @foreach($lessons as $key => $lesson)
                @if ($lesson->steps->count()!=0)
                    <div class="card-group">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5>{{$key+1}}. <a class="collection-item"
                                                           href="{{url('/insider/courses/'.$course->id.'/steps/'.$lesson->steps->first()->id)}}">{{$lesson->name}}</a>
                                        </h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        @parsedown($lesson->description)
                                    </div>
                                    @if ($lesson->percent($user) > 90)
                                        <div class="col-sm-auto">
                                            <img src="{{url($lesson->sticker)}}" style="max-width: 200px;"/>
                                        </div>
                                    @endif


                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col">

                                        <div class="progress" style="margin: 5px;">
                                            @if ($lesson->percent($user) < 40)
                                                <div class="progress-bar progress-bar-striped bg-danger"
                                                     role="progressbar"
                                                     style="width: {{$lesson->percent($user)}}%"
                                                     aria-valuenow="{{$lesson->percent($user)}}"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100">{{$lesson->points($user)}}
                                                    / {{$lesson->max_points($user)}}</div>

                                            @elseif($lesson->percent($user) < 60)
                                                <div class="progress-bar progress-bar-striped bg-warning"
                                                     role="progressbar"
                                                     style="width: {{$lesson->percent($user)}}%"
                                                     aria-valuenow="{{$lesson->percent($user)}}"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    Успеваемость: {{$lesson->points($user)}}
                                                    / {{$lesson->max_points($user)}}</div>

                                            @else
                                                <div class="progress-bar progress-bar-striped bg-success"
                                                     role="progressbar"
                                                     style="width: {{$lesson->percent($user)}}%"
                                                     aria-valuenow="{{$lesson->percent($user)}}"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    Успеваемость: {{$lesson->points($user)}}
                                                    / {{$lesson->max_points($user)}}</div>

                                            @endif
                                        </div>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="col-md-4">
            <div class="card" style="margin-top: 15px;">
                <div class="card-body">
                    <h4 class="card-title">Информация <img src="https://png.icons8.com/info/color/30/000000"></h4>
                    <p>
                        @if ($user->role=='teacher')
                            <b>Статус:</b> {{$course->state}}<br/>
                            <b>Инвайт:</b> {{$course->invite}}<br/>

                        @endif
                        @if ($course->git!=null)
                            <b><img src="https://png.icons8.com/git/color/24" title="Git" width="16" height="16"> Git
                                репозиторий:</b> <a href="{{$course->git}}">{{$course->git}}</a><br/>
                        @endif
                        @if ($course->telegram!=null)
                            <b><img src="https://png.icons8.com/telegram-app/win10/16" title="Telegram App" width="16"
                                    height="16"> Чат в телеграм:</b> <a
                                    href="{{$course->telegram}}">{{$course->telegram}}</a><br/>
                        @endif
                    </p>
                    <p>
                        <b>Преподаватели:</b>
                    </p>
                    <ul>
                        @foreach($course->teachers as $teacher)
                            <li><a class="black-link"
                                   href="{{url('/insider/profile/'.$teacher->id)}}">{{$teacher->name}}</a></li>
                        @endforeach
                    </ul>
                    <p>
                        <b>Студенты:</b>
                    </p>
                    <ul>
                        @foreach($students as $student)
                            <li><a class="black-link"
                                   href="{{url('/insider/profile/'.$student->id)}}">{{$student->name}}</a></li>
                        @endforeach
                    </ul>

                </div>

                <div class="card-footer">

                    <div class="row">
                        <div class="col">fdf
                        </div>
                        <div class="col">

                            <div class="progress" style="margin: 5px;">
                                @if ($lesson->percent($user) < 40)
                                    <div class="progress-bar progress-bar-striped bg-danger"
                                         role="progressbar"
                                         style="width: {{$lesson->percent($user)}}%"
                                         aria-valuenow="{{$lesson->percent($user)}}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">{{$lesson->points($user)}}
                                        / {{$lesson->max_points($user)}}</div>

                                @elseif($lesson->percent($user) < 60)
                                    <div class="progress-bar progress-bar-striped bg-warning"
                                         role="progressbar"
                                         style="width: {{$lesson->percent($user)}}%"
                                         aria-valuenow="{{$lesson->percent($user)}}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                        Успеваемость: {{$lesson->points($user)}}
                                        / {{$lesson->max_points($user)}}</div>

                                @else
                                    <div class="progress-bar progress-bar-striped bg-success"
                                         role="progressbar"
                                         style="width: {{$lesson->percent($user)}}%"
                                         aria-valuenow="{{$lesson->percent($user)}}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                        Успеваемость: {{$lesson->points($user)}}
                                        / {{$lesson->max_points($user)}}</div>

                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function () {
                $('[data-toggle="popover"]').popover()
            });
            $('.popover-dismiss').popover({
                trigger: 'focus'
            });
        </script>

    </div>

    <!-- Modal -->
    <div class="modal fade fade" id="addLessonModal" tabindex="-1" role="dialog" aria-labelledby="addLessonModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLessonModalLabel">Добавить урок</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <ul>
                        @foreach($available_lessons as $lesson)
                            <li>
                                <a href="{{url('/insider/courses/'.$course->id.'/add_sdl_lesson?lesson_id='.$lesson->id)}}">{{$lesson->name}}</a>
                            </li>
                        @endforeach
                    </ul>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
                </form>
            </div>
        </div>
    </div>



@endsection
