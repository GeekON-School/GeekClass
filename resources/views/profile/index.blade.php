@extends('layouts.app')

@section('content')
    <h3>Сообщество</h3>
    <div class="row" style="margin-top: 15px;">
        @foreach($users as $user)

            <div class="col-md-3">
                <div class="card bg-dark text-white">
                    <img class="card-img" src="{{url('/media/'.$user->image)}}">
                    <div class="card-img-overlay">
                        <a style="color:white;" href="{{url('/insider/profile/'.$user->id)}}"><h4 class="card-title">{{$user->name}}</h4></a>
                        <p class="card-text"><span style="font-size: 15px;" class="badge badge-pill badge-success"><i
                                        class="icon ion-ios-arrow-up"></i> Капитан</span><br><span
                                    class="badge badge-pill badge-primary">Веб-разработка</span><span
                                    class="badge badge-pill badge-primary">Фронтэнд</span></p>
                    </div>
                </div>

            </div>


        @endforeach
    </div>

@endsection
