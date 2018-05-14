@extends('layouts.app')

@section('content')
    <br>
    <form method="POST">
        {{ csrf_field() }}
        <div class="row" style = "margin-top: -30px">
            <div class="col">
                <div class="float-left">
                        <h2>
                            <div class="float-left">
                                {{$event->name}}
                            </div>

                        </h2>
                </div>

                <div class="float-right">
                    <div>
                        //ToDo
                        <img src="https://png.icons8.com/ios/50/000000/add-administrator.png" width="40px">
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style = "margin-top: 10px">
            <div class="col-md-8">
                <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5>
                                        {{$event->text}}
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col">
                                    <div style="margin: 5px;">
                                        @if($event->userPartis->contains(Auth::User()->id))
                                            <a role="button" class="btn btn-danger" href={{"/insider/events/$event->id/left"}}>Я не иду</a>
                                        @else
                                            <a role="button" class="btn btn-primary" href={{"/insider/events/$event->id/go"}}>Я иду!</a>
                                        @endif

                                            @if($event->userLikes->contains(Auth::User()->id))
                                                <a role="button" class="btn btn-warning" href={{"/insider/events/$event->id/dislike"}}>Мне не нравиться</a>
                                            @else
                                                <a role="button" class="btn btn-success" href={{"/insider/events/$event->id/like"}}>Мне нравиться</a>
                                            @endif
                                        <div class="float-right">
                                            <h3 style="margin-right: 20px"><img src="https://png.icons8.com/ultraviolet/50/000000/good-quality.png" width="35px">
                                            {{count($event->userLikes)}}</h3>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style = "margin-top: 50px">
                    <h2>Комментарии:</h2>
                </div>
                <div class="card-group" style = "margin-top: 30px">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div style="margin: 5px;">
                                        <div>*Дата*, *Имя пользователя*</div><br>
                                        <div>*Текст*</div><br>
                                        <div class="float-right">
                                            <div class="btn btn-info">Ответить</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Дополнительная информация <img src="https://png.icons8.com/info/color/30/000000" width="15px"></h5>
                        <br>
                        <b>Когда:</b> {{$event->date}}<br><br>
                        <b>Где:</b> {{$event->location}}<br><br>
                        @if($event->site != null)
                            <b>Сайт: </b><a href="https://geekclass.ru ">{{$event->site}}</a> <br><br>
                        @endif
                        <b>Теги:</b><br> "Анекдоты"<br>"JavaScript"<br/>
                        </p>
                        <p>
                            <b>Организаторы:</b><ul>
                            <li>GeekEvent</li>
                        </ul>
                        </p>
                        <ul>
                        </ul>
                        <p>
                            <b>Участники:</b><ul>
                            @foreach($users as $user)
                                @if($event->userPartis->contains($user->id))
                                    <li>{{$user->name}}</li>
                                @endif
                            @endforeach
                        </ul>
                        </p>

                    </div>
                </div>
            </div>

        </div>

@endsection