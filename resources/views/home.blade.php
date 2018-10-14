@extends('layouts.app')

@section('title')
    GeekClass
@endsection

@section('content')

    @if($user->isBirthday())
        <div class="row">
            <div class="col">
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <img src="https://png.icons8.com/color/50/000000/confetti.png"> <img
                            src="https://png.icons8.com/color/50/000000/confetti.png"> <img
                            src="https://png.icons8.com/color/50/000000/confetti.png">
                    <h3>С днем рождения!!!</h3> <img src="https://png.icons8.com/color/50/000000/confetti.png"> <img
                            src="https://png.icons8.com/color/50/000000/confetti.png"> <img
                            src="https://png.icons8.com/color/50/000000/confetti.png">
                </div>
            </div>
        </div>
    @endif

    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <h2> Курсы</h2>
        </div>
        <div class="col">
            @if ($user->role=='teacher')
                <a class="float-right btn btn-success btn-sm" href="{{url('/insider/courses/create/')}}"><i
                            class="icon ion-plus-round"></i>&nbsp;Создать</a>
            @else
                <div class="float-right">
                    <form class="form-inline" method="get" action="{{url('insider/invite')}}">
                        {{csrf_field()}}
                        <input type="text" class="form-control form-control-sm mb-2 mr-sm-2 mb-sm-0" id="invite"
                               name="invite" placeholder="Инвайт на курс">

                        <button type="submit" class="btn btn-success btn-sm"><i class="icon ion-plus-round"></i>&nbsp;Добавить
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
    @foreach($providers as $provider)
        @if ($provider->courses()->where('state', 'started')->count()!=0)
            <div class="row">
                <div class="col">
                    <h5 style="font-weight: 300;"><a target="_blank" href="{{$provider->site}}">{{$provider->name}}</a>
                    </h5>
                </div>
            </div>
            <div class="row" style="margin-top: 15px;">


                <div class="card-deck">

                    @foreach($provider->courses as $course)
                        @if ($course->state == 'started')

                            <div class="card"
                                 style="min-width: 280px; background-image: url({{$course->image}}); background-size: cover;">

                                <!--<img class="card-img-top" src="..." alt="Card image cap">-->
                                <div class="card-body" style="background-color: rgba(255,255,255,0.9);">
                                    @if ($course->provider->logo != null)
                                        <img src="{{$course->Provider->logo}}" style="margin-top: 15px;height: 50px"/>
                                    @endif
                                    <h5 style="margin-top: 15px; font-weight: 300;"
                                        class="card-title">{{$course->name}}</h5>
                                    <p class="card-text" style="font-size: 0.8rem;">{{$course->description}}</p>


                                </div>
                                <div class="card-footer" style="background-color: rgba(245,245,245,1);">
                                    @if ($user->role=='teacher' || $course->students->contains($user))
                                        <a href="{{url('insider/courses/'.$course->id)}}"
                                           class="btn btn-success btn-sm"><i
                                                    class="icon ion-ios-list-outline"></i>&nbsp;Страница
                                            курса</a>
                                    @else
                                        <a href="#" class="btn btn-success btn-sm disabled" role="button"
                                           aria-disabled="true">Вы
                                            не
                                            записаны</a>
                                    @endif

                                    @if ($course->site != null)
                                        <a target="_blank" href="{{$course->site}}" style="margin-top: 6px;"
                                           class="float-right">О курсе</a>
                                    @endif
                                </div>
                            </div>

                        @endif
                    @endforeach
                </div>

            </div>
        @endif
    @endforeach
    @if ($user->role == 'teacher')
        <div class="row" style="margin-top: 15px;">
            <div class="col">
                <h2> Черновики</h2>
            </div>
        </div>
        <div class="row" style="margin-top: 15px;">
            <div class="card-deck">
                @foreach($courses as $course)
                    @if ($course->state == 'draft')

                        <div class="card"
                             style="min-width: 280px; background-image: url({{$course->image}}); background-size: cover;">
                            <!--<img class="card-img-top" src="..." alt="Card image cap">-->
                            <div class="card-body" style="background-color: rgba(255,255,255,0.9);">
                                <h4 class="card-title">{{$course->name}}</h4>
                                <p class="card-text" style="font-size: 0.8rem;">{{$course->description}}</p>

                            </div>
                            <div class="card-footer" style="background-color: rgba(245,245,245,1);">
                                <a href="{{url('insider/courses/'.$course->id)}}" class="btn btn-success btn-sm">Страница
                                    курса</a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

        </div>

        <div class="row" style="margin-top: 15px;">
            <div class="col">
                <h2> Архив</h2>
            </div>
        </div>
        <div class="row" style="margin-top: 15px;">
            <div class="card-deck">
                @foreach($courses as $course)
                    @if ($course->state == 'ended')

                        <div class="card"
                             style="width: 100%; min-width: 280px; background-image: url({{$course->image}}); background-size: cover;">
                            <div class="card-body" style="background-color: rgba(255,255,255,0.9);">
                                <h4 class="card-title">{{$course->name}}</h4>
                                <p class="card-text" style="font-size: 0.8rem;">{{$course->description}}</p>

                            </div>
                            <div class="card-footer" style="background-color: rgba(245,245,245,1);">
                                <a href="{{url('insider/courses/'.$course->id)}}" class="btn btn-success btn-sm">Страница
                                    курса</a>
                            </div>

                        </div>

                    @endif
                @endforeach
            </div>
        </div>
    @endif



@endsection
