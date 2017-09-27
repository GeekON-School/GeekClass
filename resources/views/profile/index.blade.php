@extends('layouts.app')

@section('content')
    <h3>Сообщество</h3>
    <div class="row" style="margin-top: 15px;">
        @foreach($users as $user)

            <div class="col-md-4 col-sm-6 col-lg-3" style="margin-bottom: 15px;">
                <div class="card bg-dark text-white" style="height: 250px;">
                    <div class="card-header"><a style="color:white;"
                                                href="{{url('/insider/profile/'.$user->id)}}"><i class="icon ion-person"></i>&nbsp;{{$user->name}}</a></div>
                    <div class="card-body"
                         style="@if ($user->image!=null) background-image: url({{url('/media/'.$user->image)}}); @else  background-image: url(https://api.adorable.io/avatars/250/{{$user->id}}.png);  @endif background-size: cover;">

                        <p class="card-text"><span style="font-size: 15px;" class="badge badge-pill badge-success"><i
                                        class="icon ion-ios-arrow-up"></i> {{$user->rank()->name}}</span><br>@if ($user->is_trainee)
                                <span class="badge badge-pill badge-info">Стажер</span>
                            @endif
                            @if ($user->is_teacher)
                                <span class="badge badge-pill badge-info">Преподаватель</span>
                        @endif
                    </div>
                </div>

            </div>


        @endforeach
    </div>

@endsection
