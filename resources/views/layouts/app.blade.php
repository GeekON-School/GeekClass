<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

    <!-- Styles -->
    <!-- Latest compiled and minified CSS -->
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">



    <link rel="stylesheet" href="{{url('/css/app.css')}}">


</head>
<body class="grey lighten-5">

<nav class="nav-extended green darken-1">
    <div class="nav-wrapper">
        <a href="{{url('/')}}" class="brand-logo" style="padding-left: 20px;">@yield('title')</a>
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        @if (Auth::guest())
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="{{ route('login') }}">Вход</a></li>
                <li><a href="{{ route('register') }}">Регистрация</a></li>
            </ul>
            <ul class="side-nav" id="mobile-demo">
                <li><a href="{{ route('login') }}">Вход</a></li>
                <li><a href="{{ route('register') }}">Регистрация</a></li>
            </ul>
        @else
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="#">{{ Auth::user()->name }} <span class="caret"></span></a></li>
                <li><a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выход</a></li>
            </ul>
            <ul class="side-nav" id="mobile-demo">
                <li><a href="#">{{ Auth::user()->name }} <span class="caret"></span></a></li>
                <li><a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выход</a></li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        @endif
    </div>
    @yield('tabs')
</nav>

<div class="container">
        @if(Session::has('alert-class') and Session::get('alert-destination')=='head')
            <div class="alert {{ Session::get('alert-class') }} alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                </button>
                <strong>{{Session::get('alert-title')}}</strong> {{ Session::get('alert-text') }}
            </div>
        @endif
        @yield('content')
</div>


<!-- Latest compiled and minified CSS -->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>


<!-- Scripts -->
<!--
    <script src="{{ asset('js/app.js') }}"></script>-->

</body>
</html>
