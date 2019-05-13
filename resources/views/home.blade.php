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
                    <h3>
                        <img src="https://png.icons8.com/color/50/000000/confetti.png"> <img
                                src="https://png.icons8.com/color/50/000000/confetti.png"> <img
                                src="https://png.icons8.com/color/50/000000/confetti.png">
                        <span>С днем рождения!!!</span> <img src="https://png.icons8.com/color/50/000000/confetti.png">
                        <img
                                src="https://png.icons8.com/color/50/000000/confetti.png"> <img
                                src="https://png.icons8.com/color/50/000000/confetti.png"></h3>
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
                <ul class="nav nav-pills float-right" id="coursesTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active" role="tab"
                           aria-controls="active" aria-selected="true">Текущие</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="draft-tab" data-toggle="tab" href="#draft" role="tab"
                           aria-controls="draft" aria-selected="false">Черновики</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="archive-tab" data-toggle="tab" href="#archive" role="tab"
                           aria-controls="archive" aria-selected="false">Архив</a>
                    </li>
                    <li class="nav-item" style="margin-left: 5px;">
                        <a class="btn btn-success btn-sm nav-link" href="{{url('/insider/courses/create/')}}"><i
                                    class="icon ion-plus-round"></i>&nbsp;Создать</a>
                    </li>
                </ul>


            @else
                <div class="float-right">
                    <form autocomplete="off" class="form-inline" method="get" action="{{url('insider/invite')}}">
                        <input autocomplete="false" name="hidden" type="text" style="display:none;">
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

    <div class="tab-content" id="courses">
        <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active">
            @foreach($providers as $provider)
                @if ($provider->courses()->where('state', 'started')->count()!=0)
                    <div class="row">
                        <div class="col">
                            <h5 style="font-weight: 300;"><a target="_blank"
                                                             href="{{$provider->site}}">{{$provider->name}}</a></h5>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 15px;">
                        <div class="col-12 col-lg-6">
                            <div class="card-deck">


                                @foreach($provider->courses->where('state', 'started') as $course)


                                    <div class="card"
                                         style="min-width: 280px; background-image: url({{$course->image}}); background-size: cover;  @if($user->role=='teacher' || $course->students->contains($user))border-left: 5px solid #28a745;@endif">
                                        <div class="card-body" style="background-color: rgba(255,255,255,0.9);">
                                            <h5 style="margin-top: 15px; font-weight: 300;"
                                                class="card-title">
                                                @if ($user->role=='teacher' || $course->students->contains($user))
                                                    <a href="{{url('insider/courses/'.$course->id)}}"
                                                       style="color: #333741;">{{$course->name}}</a>
                                                @else
                                                    <a href="#" class="text-muted">{{$course->name}}
                                                        <small>(вы не записаны)</small>
                                                    </a>
                                                @endif

                                            </h5>
                                            <p class="card-text" style="font-size: 0.8rem;">{{$course->description}}</p>

                                            @if ($course->site != null)
                                                <a target="_blank" href="{{$course->site}}"
                                                   style="margin-top: 6px; font-size: 0.8rem;"
                                                   class="float-right">О курсе</a>
                                            @endif


                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12 col-lg-3">
                            <div class="card"
                                 style="min-width: 280px; border-left: 5px solid #5bc0de;">
                                <div class="card-body">
                                    @if ($provider->logo != null)
                                        <img src="{{$course->Provider->logo}}"
                                             style="margin-top: 15px;height: 60px"/>
                                    @endif

                                    <h5 style="margin-top: 15px; font-weight: 300;"
                                        class="card-title">Празднуем день рождения:</h5>
                                    <p class="card-text" style="font-size: 0.8rem;">
                                    <ul>
                                        @foreach($users->where('provider_id', $provider->id)->where('birthday', '!=', null)->sortBy(function($col){return $col->birthday->day;}) as $buser)
                                            @if ($buser->birthday->month == \Carbon\Carbon::now()->month)
                                                <li>
                                                    <a style="color: black; @if ($buser->birthday->day == \Carbon\Carbon::now()->day) font-weight: bold; @endif"
                                                       href="{{url('insider/profile/'.$buser->id)}}">{{ $buser->name }}</a>
                                                    -
                                                    <strong>{{$buser->birthday->format('d.m')}}</strong></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    </p>
                                </div>

                            </div>


                            <div class="card"
                                 style="min-width: 280px; border-left: 5px solid #007bff">
                                <div class="card-body">


                                    <h5 style="margin-top: 15px; font-weight: 300;"
                                        class="card-title">Последние вопросы:</h5>
                                    <p class="card-text" style="font-size: 0.8rem;">
                                    <ul>
                                        @foreach($threads as $thread)
                                            <li>
                                                <a style="color: black; @if ($buser->birthday->day == \Carbon\Carbon::now()->day) font-weight: bold; @endif"
                                                   href="{{url('insider/forum/'.$thread->id)}}">{{ $thread->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    </p>
                                </div>

                            </div>

                        </div>
                        <div class="col-12 col-lg-3">
                            <script type="text/javascript" src="https://vk.com/js/api/openapi.js?160"></script>

                            <!-- VK Widget -->
                            <div id="vk_groups"></div>
                            <script type="text/javascript">
                                VK.Widgets.Group("vk_groups", {mode: 4, wide: 1, width: 'auto', height: "800", color3: '28A745'}, 149395318);
                            </script>
                        </div>


                    </div>
                @endif
            @endforeach

        </div>
        @if ($user->role == 'teacher')
            <div class="tab-pane fade" id="draft" role="tabpanel" aria-labelledby="draft">
                <div class="row" style="margin-top: 15px;">
                    <div class="card-deck">
                        @foreach($courses->where('state', 'draft') as $course)

                            <div class="card"
                                 style="min-width: 280px; background-image: url({{$course->image}}); background-size: cover;">
                                <!--<img class="card-img-top" src="..." alt="Card image cap">-->
                                <div class="card-body" style="background-color: rgba(255,255,255,0.9);">
                                    <h4 class="card-title">{{$course->name}}</h4>
                                    <p class="card-text" style="font-size: 0.8rem;">{{$course->description}}</p>

                                </div>
                                <div class="card-footer" style="background-color: rgba(245,245,245,1);">
                                    <a href="{{url('insider/courses/'.$course->id)}}"
                                       class="btn btn-success btn-sm">Страница
                                        курса</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

            </div>
            <div class="tab-pane fade" id="archive" role="tabpanel" aria-labelledby="archive">
                <div class="row" style="margin-top: 15px;">
                    @foreach($courses->where('state', 'ended')->sortByDesc('start_date') as $course)
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h5 style="padding: 0; margin: 0;" class="card-title">{{$course->name}}<br>
                                                <small style="font-size: 70%;">{{$course->start_date->format('d.m.Y')}}
                                                    - {{$course->end_date->format('d.m.Y')}}</small>
                                            </h5>

                                        </div>
                                        <div class="col-md-3">
                                            <a href="{{url('insider/courses/'.$course->id)}}"
                                               class="btn btn-success btn-sm  float-right">Страница</a>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>

                    @endforeach
                </div>


            </div>
        @endif
    </div>




@endsection
