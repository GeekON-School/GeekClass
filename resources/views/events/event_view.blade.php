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
            <div class="col-md-8">
            @foreach($events as $event)
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
                                            {{$event->short_text}}
                                        <div class="float-right">
                                            <br><a href="{{url('/insider/events/'.$event->id)}}" style = "margin-bottom: 20px" class = "btn btn-primary">Перейти к событию</a><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            @endforeach
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Теги:</h2>
                        <br>
                        @foreach($tags as $tag)
                        <div class="checkbox">
                            <label><input type="checkbox" value="{{$tag->id}}">{{$tag->name}}</label>
                        </div>
                        @endforeach
                        <br><div class="float-left">
                            <input type="submit" value="Применить" class = "btn btn-success">
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection