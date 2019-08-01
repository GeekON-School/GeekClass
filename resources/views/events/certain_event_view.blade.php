@extends('layouts.full')

@section('content')
    @extends('events.event_layout')
    <br>
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
                @if($event->isOwner(Auth::User()->id))
                <form class="form-inline" method="GET" action="{{url('insider/events/'.$event->id.'/add_org')}}">
                    {{csrf_field()}}
                    <input type="text" class="form-control form-control-sm mb-2 mr-sm-2 mb-sm-0"
                           name="name" placeholder="Имя организатора">
                    <input type="submit" value="Добавить" class="btn btn-success btn-sm">
                </form>
                @endif
                </div>
            </div>
        </div>
        <div class="row" style = "margin-top: 10px">
            <div class="col-md-8">
                <div class="card-group ev">
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
                                            <a role="button" class="btn btn-danger" href={{"/insider/events/$event->id/left"}}>Я не иду</a>
                                            <a role="button" class="btn btn-primary" href={{"/insider/events/$event->id/go"}}>Я иду!</a>
                                        <div class="float-right">

                                            @include('events.event_likes', ['event' => $event])
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
                @foreach($comments as $comment)
                    @if($comment->event_id == $event->id)
                        <div class="card-group" style = "margin-top: 30px; border: none;">
                            <div class="card" style="border: none;">
                                <div class="card-footer">
                                    <div class="float-left" style="margin-left:5px">
                                        {{$comment->created_at}}, <b>{{$comment->user->name}}</b>
                                    </div>
                                    <div class="float-right">
                                        @if($comment->user_id == Auth::User()->id)
                                            <a href={{"/insider/events/$event->id/delete_comm/$comment->id"}}  onclick="return confirm('Вы уверены?')">
                                            <img src="https://png.icons8.com/windows/50/000000/cancel.png" width="25px"></a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body" style="margin-left: 5px;">
                                    {{$comment->text}}
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                <div>
                    <form method="POST" action="{{url('insider/events/'.$event->id)}}">
                        {{csrf_field()}}
                        <textarea class="form-control" rows="5" style="margin-bottom:10px" name="text"></textarea>
                        <input role="button" class="btn btn-success" value="Отправить комментарий" type="submit"/>
                    </form>
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
                            <b>Сайт: </b><a href="{{$event->site}}">{{$event->site}}</a> <br><br>
                        @endif
                        @if(count($event->tags) > 0 && !$event->tags->contains(1))
                        <b>Теги:</b>
                        <ul>
                            @foreach($tags as $tag)
                                @if($tag->id != 1)
                                @if($event->tags->contains($tag->id))
                                    <li>{{$tag->name}}</li>
                                @endif
                                @endif
                            @endforeach
                        </ul>
                        @endif
                        <p>
                            <b>Организаторы:</b><ul>
                            @foreach($users as $user)
                                @if($event->userOrgs->contains($user->id))
                                    <li>{{$user->name}}</li>
                                @endif
                            @endforeach
                        </ul>
                        </p>
                        <ul>
                        </ul>
                        <p>
                            @if($event->max_people != null)
                                <b>Студенты:
                                    {{count($event->userPartis)}}/{{$event->max_people}}
                                </b>
                            @else
                                <b>Студенты:</b>
                            @endif
                                    <ul>
                            @foreach($users as $user)
                                @if($event->userPartis->contains($user->id))
                                    <li>{{$user->name}}</li>
                                @endif
                            @endforeach
                        </ul>
                        </p>
                    </div>
                </div>
                <a role = "buttton" class="btn btn-success" href="{{url('insider/events/'.$event->id.'/edit')}}">Редактировать</a>
            </div>

        </div>
    @include('events.event_likes_script')
@endsection
