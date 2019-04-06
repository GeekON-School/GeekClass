@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{asset('codemirror.css')}}">
<style>
    /* .controls
    {
        margin: 0;
        padding: 0;
    } */
    .row {
        margin: 0;
    }

    .controls .btn {
        margin-left: 5px;
        margin-bottom: 5px;
    }

    .menu .btn {
        padding: 5px 10px;
    }
</style>
@endsection

@section('content')

<div class="row justify-content-end float-right">

    <ul class="col-lg nav row menu">


        <li class="nav-item controls col-xs">
            <a class="nav-link text-white btn btn-success" href="/insider/games/create">+</a>
        </li>

        @if ($page == 1 && (\Auth::id()==$game->user->id || \Auth::user()->role == 'teacher'))
        <li class="nav-item controls col-xs">
            <a class="nav-link btn btn-success" href="/insider/games/{{$game->id}}/edit">
                <i class="icon text-white ion-android-create"></i>
            </a>
        </li>
        @endif
        @if ($page == 1 || $page == 2 && (\Auth::id()==$game->user->id || \Auth::user()->role == 'teacher'))

        <li class="nav-item controls col-xs">
            <a class="nav-link btn btn-danger" href="/insider/games/{{$game->id}}/delete"
                onclick="return confirm('Вы уверены?')"><i class="ion-close-round"></i></a>
        </li>
        @endif

        @if ($page == 1 && (\Auth::id()!=$game->user->id || \Auth::user()->role == 'teacher'))
        <li class="nav-item controls col-xs">
            <a class="nav-link btn btn-warning" href="/insider/games/{{$game->id}}/reward">Наградить</a>
        </li>
        @endif
        @if ($page == 1)
        <li class="nav-item controls col-xs">
            <a class="nav-link btn btn-primary" href="/insider/games/{{$game->id}}/viewsource">Исходный код</a>
        </li>
        @endif
    </ul>
</div>
<div>
    
</div>
@yield('content')
@overwrite
