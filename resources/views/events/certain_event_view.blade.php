@extends('layouts.left-menu')

@section('content')
    <div class="row" >
        <div class="row col-12">
            <div class="row col-12">
                <h2 style="margin: 20px; col"><a href="/insider/events">< </a>{{ $event->name }}</h2>
                <div class="col" style="margin-top:20px;">
                <ul class="nav nav-tabs nav-fill">
                    @if($event->isOwner(Auth::User()->id))
                        <li class="nav-item" style="margin-left: 5px;">
                                <a class="btn btn-success btn-sm nav-link" style="color: white;"  href="/insider/events/{{$event->id}}/edit">Изменить</a>
                            </li>
                    @endif
                </ul>
            </div>
            </div>
            <div class="card col-12">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12" style="padding:5px;">
                                    <h4>Начало события: {{\Carbon\Carbon::parse($event->date)->format("Y.m.d в h:m")}}</h4>
                                </div>
                                <p class="col-md-12">
                                    <p style="padding:3px;">@parsedown($event->text)</p>
                                </p>

                                <a class="col-md-12" style="position:absolute; bottom :0; left:-10px;">
                                        @include('events.event_likes')
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <div class="row">
                                    <div class="col-md-12 row">
                                        <a role="button" style="margin-left:10px" class="col btn btn-danger" href={{"/insider/events/$event->id/left"}}>
                                            Я не иду
                                        </a>
                                        <a role="button" style="margin-left:10px" class="col btn btn-primary" href={{"/insider/events/$event->id/go"}}>
                                            Я иду!
                                        </a>
                                    </div>
                                    <p class="col-md-12" style="margin-top:20px;">
                                        <b>Где: </b> {{$event->location}}
                                    </p>
                                    <p class="col-md-12">
                                        <b>Сайт: </b> {{$event->site}}
                                    </p>
                                    <p class="col-md-12">
                                        <b>Организаторы: </b> 
                                        /
                                        @foreach($users as $user )
                                            @if($event->userOrgs->contains($user->id))
                                                {{$user->name}} /
                                            @endif
                                        @endforeach
                                    </p>
                                    <p class="col-md-12">
                                        <b>Студенты:
                                            {{count($event->userPartis)}}/{{$event->max_people}}: 
                                        </b>
                                        @foreach($users as $user)
                                            @if($event->userPartis->contains($user->id))
                                                <span>{{$user->name}}</span>
                                            @endif
                                        @endforeach
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                    <div style = "margin-top: 50px">
                            <h2>Комментарии:</h2>
                    </div>

                    <form method="POST" action="{{url('insider/events/'.$event->id)}}">
                        {{csrf_field()}}
                        <textarea class="form-control" rows="5" style="margin-bottom:10px" name="text"></textarea>
                        <input role="button" class="btn btn-success" value="Отправить комментарий" type="submit"/>
                    </form>
            </div>
            @foreach($comments as $comment)
                    @if($comment->event_id == $event->id)
                        <div class="col-md-12" style="margin-top: 10px;"> 
                            <div class="card">
                                <div class="card-body row">
                                    <div style="color: #777" class="col-md-12">
                                        <div class="float-left" style="margin-left:5px">
                                                <b>{{$comment->user->name}}</b>
                                            {{\Carbon\Carbon::parse($comment->created_at)->diffForHumans(\Carbon\Carbon::now())}}
                                        </div>
                                        <div class="float-right">
                                            @if($comment->user_id == Auth::User()->id)
                                                <a href={{"/insider/events/$event->id/delete_comm/$comment->id"}}  onclick="return confirm('Вы уверены?')">
                                                <img src="https://png.icons8.com/windows/50/000000/cancel.png" width="25px"></a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body col-md-12" >
                                        {{$comment->text}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
        </div>            
    </div>
    @include('events.event_likes_script')
@endsection
