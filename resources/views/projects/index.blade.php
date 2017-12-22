@extends('layouts.app')

@section('content')
    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <h2>Проекты</h2>
        </div>
        <div class="col">
            <a class="float-right btn btn-success btn-sm" href="{{url('/insider/projects/create/')}}"><i
                        class="icon ion-plus-round"></i>&nbsp;Создать</a>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        @foreach($projects as $project)

            <div class="col-md-4 col-sm-6 col-lg-3" style="margin-bottom: 15px;">
                <div class="card bg-dark text-white" style="height: 320px;">
                    <div class="card-header"><a style="color:white;" href="{{url('/insider/projects/'.$project->id)}}">{{$project->name}}</a></div>
                    <div class="card-body"
                         style=" @if ($project->url!=null) background-image: url({{$project->url}}); @else background-image: url({{url('/media/project_avatars/test.jpg')}}); @endif background-size: cover; ">

                        @if($project->type != "")
                        <p class="card-text">
                            <div class="float bottom">
                            <span style="font-size: 15px;" class="badge badge-pill badge-success">
                                <i class ="icon ion-ios-arrow-up"> </i>{{$project->type}}</span>
                        </div>
                            @endif
                        @if ($project->tags != "")
                            @php($tags = explode(" ",$project->tags))

                            @foreach($tags as $tag)
                                <span style="font-size: 15px; margin-top: 15px" class="badge badge-pill badge-info"><i
                                            class="icon ion-ios-arrow-right"></i> {{$tag}}</span><br>
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>


        @endforeach
    </div>

@endsection
