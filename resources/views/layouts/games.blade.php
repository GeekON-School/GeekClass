@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{asset('codemirror.css')}}">
@endsection

@section('content')
<div class="row" style="margin-bottom: 50px;">
    <h1 class="col">@yield('heading', 'N/A')</h1>
    <div class="col nav row justify-content-between">
        <li class="nav-item">
            <a class="nav-link {{$page!=0?'disabled':''}}" href="{{$page==0?'javascript:void(0)':'/insider/games/'}}">Смотреть</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{$page!=1?'disabled':''}}" href="javascript:void(0)">Играть</a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{$page!=2?'disabled':''}}" href="{{$page==2?'javascript:void(0)':'/insider/games/create'}}">Создать</a>
        </li>
    </div>
</div>
@yield('content_p')
@endsection