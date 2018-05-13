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
                    <a href="{{url('/insider/events/add_event')}}" style = "margin-left: 50px" class = "btn btn-success">Провести событие</a>
                </div>

            </div>
        </div>
        <div class="row" style = "margin-top: 10px">
            @foreach($events as $event)
                <div class="col-md-8">
                    <div class="card-group">
                        <div class="card">
                            <div class="card-footer">
                                <div class="float-left">
                                    {{$event->name}}, ({{$event->type}})
                                </div>
                                <div class="float-right">
                                    {{$event->date}}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="card-body">
                                        {{$event->text}}
                                        <div class="float-right">
                                            <br><a href="{{url('/insider/events/'.$event->id)}}" style = "margin-bottom: 20px" class = "btn btn-primary">Перейти к событию</a><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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
                            <label><input type="checkbox" value="">Анеки</label>
                        </div>
                        <br><div class="float-left">
                            <input type="submit" value="Применить" class = "btn btn-success">
                        </div>

                    </div>
                </div>
            </div>
        </div>

@endsection