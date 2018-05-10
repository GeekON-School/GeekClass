@extends('layouts.app')

@section('content')
    <br>
    <form method="POST">
        {{ csrf_field() }}
            <div class="row" style = "margin-top: -30px">
                    <div class="col">
                        <div class="float-left">
                            <h2>События</h2>
                        </div>
                        <div class="float-right">
                            <a href="{{url('/insider/events/add_event')}}" style = "margin-left: 50px" class = "btn btn-success">Добавить событие</a>
                        </div>
                        <a href="{{url('/insider/events/certain_event')}}" style = "margin-left: 50px" class = "btn btn-success">Перейти к событию</a>
                    </div>
            </div>
            <div class="row" style = "margin-top: 10px">
                <div class="col-md-8">
                            <div class="card-group">
                                <div class="card">
                                        <div class="card-footer">
                                                </div>

                                            <div class="row">
                                                <div class="col">
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                            <h2 class="card-title">Теги:</h2>
                            <br>
                    <div class="checkbox">
                        <label><input type="checkbox" value="">Web</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="">Python</label>
                    </div>
                    <div class="checkbox disabled">
                        <label><input type="checkbox" value="">Security</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="">Machine learning</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="">Blockchain</label>
                    </div>
                    <div class="checkbox disabled">
                        <label><input type="checkbox" value="">Анекдоты</label>
                    </div>
                    <br><div class="float-left">
                        <input type="submit" value="Применить" class = "btn btn-success">
                    </div>

                </div>
            </div>
        </div>
            </div>

@endsection