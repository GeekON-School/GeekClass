@extends('layouts.app')

@section('content')
    <br>
        <div class="row" style = "margin-top: -30px">
            <div class="col" style="margin: -10px">
                <div class="float-left">
                    <h2 class="nav-link" style="color: blue">События</h2>
                </div>
                <div class="text-center" style="margin-right: 10px">
                    <a class="nav-link" href="{{url('/insider/events/old')}}" style="color:black"><h2>Архив событий</h2></a>
                </div>
                <div class="float-right" style="margin-top: -50px;">
                    <a href="{{url('/insider/events/add_event')}}" class = "btn btn-success">Провести событие</a>
                </div>
            </div>
        </div>
        <div class="row" style = "margin-top: 10px">
            <div class="col-md-8">
            @foreach($events as $event)
                @if(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $event->date)->gt(\Carbon\Carbon::now()))
                @foreach($event->tags as $tag)
                        @if(in_array($tag->id, $s_tags))
                    <div class="card-group">
                        <div class="card" style="border: 1px solid grey">
                            <div class="card-footer">
                                <div class="text-center" style="margin-bottom: -33px">
                                    <h4><b>{{$event->name}}, ({{$event->type}})</b></h4>
                                </div>
                                <div class="float-left">
                                    @if($event->userLikes->contains(Auth::User()->id))
                                        <a href={{"/insider/events/$event->id/dislike_from_events"}}>
                                            <img src="https://png.icons8.com/color/50/000000/hearts.png" width="35px"></a>
                                    @else
                                        <a href={{"/insider/events/$event->id/like_from_events"}}>
                                            <img src="https://png.icons8.com/ios/50/000000/hearts.png" width="35px"></a>
                                    @endif
                                    {{count($event->userLikes)}}
                                </div>
                                <div class="float-right" style="margin-right:15px">
                                    <b>{{$event->date}}</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card-body">
                                            {{$event->short_text}}
                                        <div class="float-right">
                                            <a href="{{url('/insider/events/'.$event->id)}}" style="margin-top: -5px"
                                               class = "btn btn-primary">Перейти к событию</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @break
                        @endif
                   @endforeach
                    @endif
                @endforeach
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Теги:</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            {{ csrf_field() }}
                            <div class="form-group form-check">
                                @foreach($tags as $tag)
                                    @if($tag->id !=1)
                                        <div class="form-check">
                                            <input type="checkbox" style="margin-left:5px" name="sel_tags[]" class="form-check-input" value="{{$tag->id}}" id="{{$tag->id}}"
                                                   @if((in_array($tag->id, $s_tags)) && ($s_tags[0] != 1)) checked @endif>
                                            <label for="{{$tag->id}}" class="form-check-label" style="margin-left:2px" >{{$tag->name}}</label>
                                        </div>
                                    @endif
                                @endforeach
                                <br>
                                <div class="float-left">
                                    <input type="submit" value="Применить" class = "btn btn-success">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection