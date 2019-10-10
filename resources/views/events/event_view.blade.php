@extends('layouts.full')

@section('content')
        <div class="mx-auto col-md-11 col-12">
            <div class="row" >
                <div class="col-md-6">
                    <h2>События</h1>
                </div>
                <div class="col-md-6" >
                    <ul class="nav nav-pills float-right" style="padding-right:15px;">
                        <li class="nav-item" style="margin-left: 5px;">
                                <a class="nav-link active" id="active-tab" data-toggle="tab" href="#future" role="tab" aria-controls="active" aria-selected="true">Будущие</a>
                        </li>
                        <li class="nav-item" style="margin-left: 5px;">
                                <a class="nav-link" data-toggle="tab" href="#past" role="tab" aria-controls="active" aria-selected="true">Прошедшие</a>
                        </li>
                        <li class="nav-item" style="margin-left: 5px;">
                            <a class="btn btn-success btn-sm nav-link" href="/insider/events/create"><i class="icon ion-plus-round"></i>&nbsp;Создать</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="row">
                    <div class="tab-pane fade show active card-deck" id="future" style="width:100%;">
                        @foreach ($events as $event)
                            <div class="card" style="min-width: 45%; border-left: 3px solid #28a745;">
                                <div class="card-body">
                                    <h5><a href="/insider/events/{{$event->id}}">{{$event->name}}</a></h5>
                                    <p>{{$event->short_text}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="tab-pane fade show card-deck" id="past" style="width:100%;">
                            @foreach ($old_events as $event)
                                <div class="card" style="min-width: 45%; border-left: 3px solid #28a745;">
                                    <div class="card-body">
                                        <h5><a href="/insider/events/{{$event->id}}">{{$event->name}}</a></h5>
                                        <p>{{$event->short_text}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                </div>
            </div>
        </div>
    @include('events.event_likes_script')
@endsection
