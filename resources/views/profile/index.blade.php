@extends('layouts.full')

@section('content')
    <h3 class="lead" style="margin-left:15px;">Преподавательский состав</h3>
    <div class="row" style="margin-top: 15px;margin-left: 0;margin-right: 0;">
        @foreach($users as $user)
            @if ($user->is_teacher && !$user->is_hidden)
                <div class="col-md-3 col-sm-4 col-6 col-lg-2" style="margin-bottom: 15px; padding: 5px;">

                    <div class="card bg-dark text-white" style="height: 250px;">
                        <div class="card-header"><a style="color:white;"
                                                    href="{{url('/insider/profile/'.$user->id)}}"><i
                                        class="icon ion-person"></i>&nbsp;{{$user->name}}</a></div>
                        <div class="card-body"
                             style="@if ($user->image!=null) background-image: url({{url('/media/'.$user->image)}}); @else  background-image: url(https://api.adorable.io/avatars/250/{{$user->id}}.png);  @endif background-size: cover; padding: 10px;">

                            <p class="card-text"><span style="font-size: 15px;"
                                                       class="badge badge-pill badge-success"><i
                                            class="icon ion-ios-arrow-up"></i> {{$user->rank()->name}}</span><br>@if ($user->is_trainee)
                                    <span class="badge badge-pill badge-info">Стажер</span>
                                @endif
                                @if ($user->is_teacher)
                                    <span class="badge badge-pill badge-info">Преподаватель</span>
                            @endif
                        </div>
                    </div>

                </div>
            @endif
        @endforeach
    </div>
    <h3 class="lead" style="margin-left:15px;">Кадровый резерв</h3>
    <div class="row" style="margin-top: 15px;margin-left: 0;margin-right: 0;">
        @foreach($users as $user)
            @if ($user->is_trainee && !$user->is_hidden)
                <div class="col-md-3 col-sm-4 col-6 col-lg-2" style="margin-bottom: 15px; padding: 5px;">

                    <div class="card bg-dark text-white" style="height: 250px;">
                        <div class="card-header"><a style="color:white;"
                                                    href="{{url('/insider/profile/'.$user->id)}}"><i
                                        class="icon ion-person"></i>&nbsp;{{$user->name}}</a></div>
                        <div class="card-body"
                             style="@if ($user->image!=null) background-image: url({{url('/media/'.$user->image)}}); @else  background-image: url(https://api.adorable.io/avatars/250/{{$user->id}}.png);  @endif background-size: cover; padding: 10px;">

                            <p class="card-text"><span style="font-size: 15px;"
                                                       class="badge badge-pill badge-success"><i
                                            class="icon ion-ios-arrow-up"></i> {{$user->rank()->name}}</span><br>@if ($user->is_trainee)
                                    <span class="badge badge-pill badge-info">Стажер</span>
                                @endif
                                @if ($user->is_teacher)
                                    <span class="badge badge-pill badge-info">Преподаватель</span>
                            @endif
                        </div>
                    </div>

                </div>
            @endif
        @endforeach
    </div>
    <h3 class="lead" style="margin-left:15px;">Личный состав</h3>
    <div class="row" style="margin-top: 15px;margin-left: 0;margin-right: 0;">
        @foreach($users as $user)
            @if (!$user->is_trainee && !$user->is_teacher && !$user->is_hidden)
                <div class="col-md-3 col-sm-4 col-6 col-lg-2" style="margin-bottom: 15px; padding: 5px;">

                    <div class="card bg-dark text-white" style="height: 250px;">
                        <div class="card-header"><a style="color:white;"
                                                    href="{{url('/insider/profile/'.$user->id)}}"><i
                                        class="icon ion-person"></i>&nbsp;{{$user->name}}</a></div>
                        <div class="card-body"
                             style="@if ($user->image!=null) background-image: url({{url('/media/'.$user->image)}}); @else  background-image: url(https://api.adorable.io/avatars/250/{{$user->id}}.png);  @endif background-size: cover; padding: 10px;">

                            <p class="card-text"><span style="font-size: 15px;"
                                                       class="badge badge-pill badge-success"><i
                                            class="icon ion-ios-arrow-up"></i> {{$user->rank()->name}}</span><br>@if ($user->is_trainee)
                                    <span class="badge badge-pill badge-info">Стажер</span>
                                @endif
                                @if ($user->is_teacher)
                                    <span class="badge badge-pill badge-info">Преподаватель</span>
                            @endif
                        </div>
                    </div>

                </div>
            @endif
        @endforeach
    </div>

@endsection
