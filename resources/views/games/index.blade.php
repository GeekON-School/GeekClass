@extends('layouts.games', ['page' => 0])

@section('heading')
Игры
@endsection

@section('content_p')
<div class="row">
    <div class="card-deck col row">
        <style scoped>
            .card {
                min-width: 45%;
            }

            .meta {
                padding-right: 10px;
            }
            .row
            {
                margin: 0;
            }
        </style>

        @foreach($games as $game)

        <div class="card col">

            <div class="card-body">
                <div class="d-flex">
                    <div >
                        @include('games/upvoteswidget', ['game' => $game])
                    </div>
                    <div style="flex:1;">

                        <h4>{{ $game->title }}</h4>
                        <div class="d-flex justify-content-between">
                            <p class="text-secondary">{{ str_limit($game->description, 100) }}</p>
                            <div class="row-sm">

                            </div>
                        </div>

                        <div style="margin-top:5px" class="row">

                            <p class="meta">Автор: {{$game->user->name}}</p>

                            @if ($game->getReward() > 0)
                            <img src="https://png.icons8.com/color/50/000000/coins.png" width="20" height="20"
                                alt="Rewarded: ">
                            <p class="meta">{{$game->getReward()}}</p>
                            @endif
                        </div>
                        <div class="d-flex" >
                                <a class="meta" href="/insider/games/{{$game->id}}">Играть</a>
                                @if (\Auth::id()==$game->user->id || \Auth::user()->role == 'teacher')
                                <a href="/insider/games/{{$game->id}}/edit" class="meta">Изменить</a>
                                @endif
                                @if (\Auth::id()!=$game->user->id || \Auth::user()->role == 'teacher')
                                <a href="/insider/games/{{$game->id}}/reward" class="meta">Наградить</a>
                                @endif
                            </div>
    
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection