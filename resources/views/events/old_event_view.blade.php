@extends('layouts.app')

@section('content')
    <br>
    <div class="row" style = "margin-top: -30px">
        <div class="col" style="margin: -10px">
            <div class="float-left">
                <a class="nav-link" href="{{url('/insider/events')}}" style="color:black" ><h2>События</h2></a>
            </div>
            <div class="text-center" style="margin-right: 10px">
                <h2 class="nav-link" style="color: blue">Архив событий</h2>
            </div>
        </div>
    </div>
    <div class="row" style = "margin-top: 10px">
        <div class="col-md-8">
            @foreach($events as $event)
                    <div class="card-group">
                        <div class="card" style="border: none;">
                            <div class="row" style="display: flex; justify-content: space-between;">
                                <div class="text-center">
                                    <h4><b>{{$event->name}}, ({{$event->type}})</b></h4>
                                </div>
                                <div onclick="toggleLike({{$event->id}}, $(this));" style="cursor: pointer;" data-liked="{{$event->hasLiked(Auth::id()) ? 'true' : 'false'}}">
                                    @if($event->hasLiked(Auth::User()->id))
                 
                                            <img src="https://png.icons8.com/color/50/000000/hearts.png" width="35px"></a>
                                    @else
                                        
                                            <img src="https://png.icons8.com/ios/50/000000/hearts.png" width="35px"></a>
                                    @endif
                                    <span class="likes1">{{count($event->userLikes)}}</span>
                                </div>
                                <div style="margin-right:15px">
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
        </div>
        <script>
        function dislike(id, el) {
            el.children('img').attr('src', 'https://png.icons8.com/ios/50/000000/hearts.png');
            $.ajax({
                url: '/insider/events/'+id+'/dislike_from_events',
                async: false
            });
            $.ajax({
                url: 'http://localhost:8050/insider/events/'+id+'/api',
                success: function(result)
                {
                    var json = JSON.parse(result);
                    console.log(json.likes)
                    el.children('.likes1').html(json['likes']);
                }
            })
        }
        function like(id, el) {
            el.children('img').attr('src', 'https://png.icons8.com/color/50/000000/hearts.png');

            $.ajax({
                url: '/insider/events/'+id+'/like_from_events',
                async: false
            });
            $.ajax({
                url: 'http://localhost:8050/insider/events/'+id+'/api',
                success: function(result)
                {
                    var json = JSON.parse(result);
                    el.children('.likes1').html(json['likes']);
                }
            })
        }
        function toggleLike(id, el)
        {
            if (el.attr('data-liked') == 'true')
            {
                dislike(id, el);
                el.attr('data-liked', 'false');
            }
            else
            {
                like(id, el);
                el.attr('data-liked', 'true');
            }

        }
    </script>
@endsection