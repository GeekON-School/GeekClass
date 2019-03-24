@extends('layouts.games', ['page' => 0])

@section('heading')
Игры
@endsection

@section('content_p')
<div class="row">
    <div class="card-deck col">
        <style scoped>
        .card
        {
            min-width: 40%;
        }
        .meta
        {
            padding: 0 10px;
        }

    </style>

    @foreach($games as $game)
    <div class="card">
        <div class="card-body">
            <h4>{{ $game->title }}</h4>
            <div class="d-flex justify-content-between">
                <p class="text-secondary">{{ str_limit($game->description, 100) }}</p>
                <div class="row-sm">
                    
                </div>
            </div>
            <div class="d-flex">
<a class="meta" href="/insider/games/{{$game->id}}">Играть</a>
                    @if (\Auth::id()==$game->user->id || \Auth::user()->role == 'teacher')
                    <a href="/insider/games/{{$game->id}}/edit" class="meta">Изменить</a>
                    @endif 
                    @if (\Auth::id()!=$game->user->id || \Auth::user()->role == 'teacher')
                    <a href="/insider/games/{{$game->id}}/reward" class="meta">Наградить</a>
                    @endif
                @include('games/upvoteswidget', ['game' => $game])
            </div>

                <div class="row" style="margin-top:5px">

                    <p class="meta">Автор: {{$game->user->name}}</p>

                @if ($game->getReward() > 0)
                    
        <img src="https://png.icons8.com/color/50/000000/coins.png" width="20" height="20" alt="Rewarded: ">
                    <p class="meta">{{$game->getReward()}}</p>
                    @endif
                    </div>
        </div>
    </div>
    @endforeach
</div>
</div>
@endsection