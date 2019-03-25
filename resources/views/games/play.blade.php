@extends('layouts.games', ['page' => 1])

@section('heading')
Играть
@endsection

@section('content_p')
<style>
    .row
    {
        margin: 0;
    }
</style>
<div class="row">
    <style scoped>
        .card {
            margin: 5px;
        }

        .meta {
            padding-left: 20px;
        }
    </style>
    <div class="card col-md-7">
        <div class="card-body">
            <iframe src="/insider/games/{{$game->id}}/frame" width="100%" height="450px" frameborder="0"
                sandbox="allow-same-origin allow-scripts"></iframe>
        </div>
    </div>
    <div class="card col" style="height:500px;">
        <div class="card-body" style="height:100%;">
            <div class="d-flex" style="height:100%;">
                <div>@include('games/upvoteswidget', ['game' => $game])</div>

                <div class="flex-1 d-flex flex-column" style="min-height:100%;max-height:100%;height:100%;">

                    {{-- <a href="/insider/games/{{$game->id}}/viewsource">Смотреть код</a> --}}
                    <div style="overflow:auto; flex:1;">
                        <h4>{{ $game->title }}</h4>
                        <div class="d-flex justify-content-between flex-column">
                            <p class="text-secondary">{!!clean(parsedown($game->description))!!}</p>
                            <div class="d-flex">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between" style="margin-top: 20px">
                        <div class="row">

                        <p>Автор: {{$game->user->name}}</p>

                        @if (\Auth::id()==$game->user->id || \Auth::user()->role == 'teacher')
                        <a href="/insider/games/{{$game->id}}/edit" class="meta">Изменить</a>
                        @endif

                        @if (\Auth::id()!=$game->user->id || \Auth::user()->role == 'teacher')
                        <a href="/insider/games/{{$game->id}}/reward" class="meta">Наградить</a>
                        @endif
                    </div>

                        @if ($game->getReward() > 0)
                        <div class="meta row">

                            <img src="https://png.icons8.com/color/50/000000/coins.png" width="20" height="20"
                                alt="Rewarded: ">
                            <p>{{$game->getReward()}}</p>
                        </div>
                        @endif
                    </div>

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
        <textarea class="form-control" id="commentArea" rows="10" type="text" name="comment">{{old('comment')}}</textarea>
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
                <a class="nav-link btn btn-danger"
                    style="padding: 8px 9px;height: 40px; margin: 0 0; margin-left: 5px; width: 40px;"
                    href="/insider/games/comments/{{$comment->id}}/delete" onclick="return confirm('Вы уверены?')"><i
                        class="ion-close-round"></i></a>
                @endcan
            </div>
            <blockquote>{!!clean(parsedown($comment->comment))!!}</blockquote>
        </div>
    </div>
</div>
@endforeach

<script>
        var simplemde_text = new EasyMDE({
               spellChecker: false,
               autosave: true,
               element: document.getElementById("commentArea")
           });
           </script>
@endsection