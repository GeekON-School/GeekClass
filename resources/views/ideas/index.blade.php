@extends('layouts.app')

@section('content')
    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <h2>Идеи</h2>
        </div>
        <div class="col">
            <a class="float-right btn btn-success btn-sm" href="{{url('/insider/ideas/create/')}}"><i
                        class="icon ion-plus-round"></i>&nbsp;Добавить</a>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">


        @foreach($ideas as $letter => $list)
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{$letter}} </h5>
                        <ul>

                            @foreach($list as $idea)
                                <li><a href="{{url('/insider/ideas/'.$idea->id)}}">{{$idea->name}}</a>&nbsp;<img style="height: 25px;" src="https://img.icons8.com/color/48/000000/idea-sharing.png">
                                    @if($idea->author->role=='student') &nbsp;<img style="height: 25px;" src="https://img.icons8.com/color/48/000000/teamwork.png" title="Идея сообщества"> @endif
                                    <br>
                                    <span class=" text-muted">{{$idea->short_description}}</span></li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>

        @endforeach


    </div>

@endsection
