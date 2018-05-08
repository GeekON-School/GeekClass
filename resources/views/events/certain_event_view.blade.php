@extends('layouts.app')

@section('content')
    <br>
    <form method="POST">
        {{ csrf_field() }}
        <div class="row" style = "margin-top: -40px">
            <div class="col">
                <div class="float-left">
                    <h2 style="margin-top: -25px">Название события</h2>
                </div>
                <div class="float-right">
                    <a href="{{url('/insider/courses/create')}}" class="btn btn-primary btn-sm"><i
                                class="icon ion-compose"></i></a>
                    <a href="{{url('/insider/courses/edit')}}"
                       class="btn btn-primary btn-sm"><i
                                class="icon ion-android-create"></i></a>
                    <a href="{{url('/insider/courses/export')}}"
                       class="btn btn-primary btn-sm"><i
                                class="icon ion-ios-cloud-download"></i></a>
                    <a href="{{url('/insider/courses/start')}}"
                       class="btn btn-success btn-sm"><i
                                class="icon ion-power"></i></a>
                    <a href="{{url('/insider/courses/stop')}}"
                       class="btn btn-danger btn-sm"><i
                                class="icon ion-stop"></i></a>
                </div>
            </div>
        </div>
        <div class="row" style = "margin-top: 30px">
            <div class="col-md-8">
                <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5>
                                    </h5>
                                </div>
                                <div class="col-sm-auto">
                                    <a href="{{url('insider/lessons/edit')}}"
                                       class="btn btn-success btn-sm"><i
                                                class="icon ion-android-create"></i></a>
                                    <a href="{{url('insider/lessons/export')}}"
                                       class="btn btn-success btn-sm"><i
                                                class="icon ion-ios-cloud-download"></i></a>
                                    <a href="{{url('insider/lessons/lower')}}"
                                       class="btn btn-success btn-sm"><i
                                                class="icon ion-arrow-up-c"></i></a>
                                    <a href="{{url('insider/lessons/upper')}}"
                                       class="btn btn-success btn-sm"><i
                                                class="icon ion-arrow-down-c"></i></a>
                                </div>
                            </div>

                            <div class="row">


                            </div>


                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col">
                                    <div class="progress" style="margin: 5px;">
                                        <div class="progress-bar progress-bar-striped bg-danger"
                                             role="progressbar"
                                             aria-valuenow=""
                                             aria-valuemin="0"
                                             aria-valuemax="100"></div>

                                        <div class="progress-bar progress-bar-striped bg-warning"
                                             role="progressbar"
                                             aria-valuenow=""
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                            Успеваемость: </div>

                                        <div class="progress-bar progress-bar-striped bg-success"
                                             role="progressbar"
                                             aria-valuenow=""
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                            Успеваемость: </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="progress" style="margin: 5px;">
                                    <div class="progress-bar progress-bar-striped bg-danger"
                                         role="progressbar"
                                         aria-valuenow=""
                                         aria-valuemin="0"
                                         aria-valuemax="100"></div>

                                    <div class="progress-bar progress-bar-striped bg-warning"
                                         role="progressbar"
                                         aria-valuenow=""
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                        Успеваемость: </div>

                                    <div class="progress-bar progress-bar-striped bg-success"
                                         role="progressbar"
                                         aria-valuenow=""
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                        Успеваемость: </div>

                                </div>
                                <small class="text-muted float-right" style="margin-right: 15px;">

                                </small>
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
                        <b>Когда:</b> 12.12.2018<br><br>
                        <b>Где:</b> Хорошевская гимназия<br><br>
                        <b>Сайт:</b><a href="https://geekclass.ru "> https://geekclass.ru</a> <br><br>
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