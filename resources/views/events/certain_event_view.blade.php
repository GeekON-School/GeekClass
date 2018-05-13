@extends('layouts.app')

@section('content')
    <br>
    <form method="POST">
        {{ csrf_field() }}
        <div class="row" style = "margin-top: -30px">
            <div class="col">
                <div class="float-left">
                        <h2>{{$event->name}}</h2>
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
                                        <a role="button" class="btn btn-primary" href={{"/insider/events/$event->id/go"}}>Я иду!</a>
                                        <div class="float-right">
                                            <div role="button" class="btn btn-success">Мне нравиться</div>
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
                            <li>Вупсень</li>
                            <li>Пупсень</li>
                        </ul>
                        </p>

                    </div>
                </div>
            </div>

        </div>

@endsection