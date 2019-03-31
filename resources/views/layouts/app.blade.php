<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>

    <!-- Styles -->
    <!-- Latest compiled and minified CSS -->
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
          integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <link rel="stylesheet" href="{{url('/css/app.css')}}">
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"
            integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
            crossorigin="anonymous"></script>
    <script src="{{url('/js/linkify.min.js')}}"></script>
    <script src="{{url('/js/linkify-jquery.min.js')}}"></script>
    <link rel="stylesheet"
          href="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.12.0/build/styles/atelier-lakeside-light.min.css">
    <script src="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.12.0/build/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{url('css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{url('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="{{url('js/jquery-ui.min.js')}}"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">

    {!! \NoCaptcha::renderJs() !!}
    <script>
        $(function () {
            $(".nav-link").click(function () {
                $(".nav-link.active").removeClass('active');
            });
        });
        $(function () {
            $(".date").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "1940:2025",
                dateFormat: 'yy-mm-dd'
            });

        });
    </script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="{{url('/js/bootstrap-select.min.js')}}"></script>
    @yield('head')

</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a href="{{url('/')}}" class="navbar-brand" href="#"><img style="height: 35px;" src="{{url('images/hlogo.png')}}"/></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        @if (Auth::check())
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{(Request::is('insider/courses*') ? 'active' : '') }}">
                    <a class="nav-link" href="{{url('/insider/courses')}}">Курсы <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item {{(Request::is('insider/forum*') ? 'active' : '') }}">
                    <a class="nav-link" href="{{url('insider/forum')}}">Ответы</a>
                </li>
                <li class="nav-item {{(Request::is('insider/ideas*') ? 'active' : '') }}">
                    <a class="nav-link" href="{{url('insider/ideas')}}">Идеи</a>
                </li>
                <li class="nav-item {{(Request::is('insider/community*') ? 'active' : '') }}">
                    <a class="nav-link" href="{{url('insider/community')}}">Сообщество</a>
                </li>
                <li class="nav-item {{(Request::is('insider/projects*') ? 'active' : '') }}">
                    <a class="nav-link" href="{{url('insider/projects')}}">Проекты</a>
                </li>
                <li class="nav-item {{(Request::is('insider/events*') ? 'active' : '') }}">
                    <a class="nav-link" href="{{url('insider/events')}}">События</a>
                </li>
                <li class="nav-item {{(Request::is('insider/market*') ? 'active' : '') }}">
                    <a class="nav-link" href="{{url('insider/market')}}">Магазин</a>
                </li>
                <li class="nav-item {{(Request::is('insider/game*') ? 'active' : '') }}">
                    <a class="nav-link" href="{{url('insider/games')}}">Игры</a>
                </li>
            </ul>

            <ul class="navbar-nav" style="width: 260px;">
            <span style="margin-top: 8px; color: white;" data-container="body" data-placement="bottom"
                  data-content="{!! Auth::user()->getHtmlTransactions() !!}" data-html="true" data-toggle="popover">
               <img src="https://png.icons8.com/color/50/000000/coins.png"
                    style="height: 23px;">&nbsp;{{Auth::user()->balance()}}&nbsp;&nbsp;

            </span>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}</a>

                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="{{url('insider/profile')}}"><i class="icon ion-person"></i>
                            Профиль</a>
                        @if (\Auth::User()->role != 'student')
                            <a class="dropdown-item" href="{{url('insider/scales')}}"><i
                                        class="icon ion-university"></i> Шкалы</a>
                        @endif
                        <a class="dropdown-item" href="{{url('insider/core/'.\Auth::User()->id)}}"><i
                                    class="icon ion-map"></i> Карта</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="icon ion-reply"></i>Выход</a>

                    </div>
                </li>
            </ul>
        @endif
    </div>
</nav>

<div class=" mx-auto col-md-9 col-11" style="margin-top: 30px;">
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


<!-- Compiled and minified JavaScript -->


<!-- Scripts -->
<!--
    <script src="{{ asset('js/app.js') }}"></script>-->
<form style="display: none;" id="logout-form" method="POST" action="{{ route('logout') }}">{{ csrf_field() }}</form>
<script>
    var url = document.location.toString();



    if (url.match('#')) {
        $('a[href="#' + url.split('#')[1] + '"]').tab('show');
        console.log(url.split('#')[1]);
    }

    // Change hash for page-reload
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    });

    $('div').linkify({
        target: "_blank"
    });
    $('div.markdown a').attr('target', 'blank');
    $(document).ready(function () {
        $('.selectpicker').selectpicker();
    });

    // define a handler
    function doc_keyUp(e) {

        // this would test for whichever key is 40 and the ctrl key at the same time
        if (e.ctrlKey && e.keyCode == 81) {
            // call your function to do the thing
            location.href = "/aesthethics"
        }
    }

    // register the handler
    document.addEventListener('keyup', doc_keyUp, false);
    $(document).popover({
        selector: '[data-toggle=popover]',
        trigger: 'hover'
    });


</script>

</body>
</html>