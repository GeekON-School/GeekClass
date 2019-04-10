@extends('layouts/full')

@section('head')
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
    @yield('head')    
@overwrite

@section('content')
    <div class="mx-auto col-md-9 col-11" style="margin-top: 30px">
        @yield('content')
    </div>
@overwrite