@extends('layouts.games', ['page' => 1])

@section('heading')
Играть
@endsection

@section('content_p')
<div class="row">
    <style scoped>
        .card
        {
            margin: 5px;
        }
        .meta
        {
            padding-right: 20px;
        }
    </style>
    <div class="card col-md-7">
        <div class="card-body">
            <iframe src="/insider/games/{{$game->id}}/frame" width="100%" height="450px" frameborder="0" sandbox="allow-same-origin allow-scripts"></iframe>
        </div>
    </div>
    <div class="card col">
        <div class="card-body">
  <a href="/insider/games/{{$game->id}}/viewsource">Смотреть код</a>
            <div class="d-flex justify-content-between" style="margin-bottom: 20px">
                <div>@include('games/upvoteswidget', ['game' => $game])</div>
                            
            @if (\Auth::id()==$game->user->id || \Auth::user()->role == 'teacher')
                            <a href="/insider/games/{{$game->id}}/edit">Изменить</a>
                        @endif 
                      
                         @if (\Auth::id()!=$game->user->id || \Auth::user()->role == 'teacher')
                    <a href="/insider/games/{{$game->id}}/reward" class="meta">Наградить</a>
                    @endif
            </div>

            <h4>{{ $game->title }}</h4>
            <div class="d-flex justify-content-between flex-column">
                <p class="text-secondary">{{ $game->description }}</p>
                <div class="d-flex">
                    <p class="meta">Автор: {{$game->user->name}}</p>
                </div>
            </div>
        </div>
    </div>

</div>
    <form action="/insider/games/{{$game->id}}/comment" method="POST">
@csrf

    <div id="comment">
        <h4 style="margin: 20px;"><label for="title">Комментарий:</label></h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <div>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif
        <textarea class="form-control" rows="10" type="text" name="comment" >{{old('comment')}}</textarea>
        <input class="btn btn-primary" type="submit" style="margin:10px 0;" value="Оставить комментарий">
    </div>
    </form>

    @foreach($game->comments as $comment)
        <div class="row">
            <div class="card col">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <p class="text-secondary">{{$comment->user->name}}</p>
                        @can('delete', $comment)
                            <a class="nav-link btn btn-danger" style="padding: 8px 9px;height: 40px; margin: 0 0; margin-left: 5px; width: 40px;" href="/insider/games/comments/{{$comment->id}}/delete" onclick="return confirm('Вы уверены?')"><i class="ion-close-round"></i></a>
                        @endcan
                    </div>
                    <blockquote>{{$comment->comment}}</blockquote>
                </div>
            </div>
        </div>
    @endforeach
@endsection
