@extends('layouts.app')

@section('title')
    GeekClass: "{{$project->name}}"
@endsection

@section('tabs')

@endsection


@section('content')

    <div class="row">
        {{ csrf_field() }}
        <div class="col">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            @if ($user->role=='teacher'|| $guest->id==$user->id)
                                <div class="col">

                                    <div class="float-right">
                                        {{ csrf_field() }}
                                        <a href="{{url('/insider/projects/'.$project->id.'/edit')}}"
                                           class="btn btn-primary btn-sm">Редактировать</a>
                                        <a href="{{url('/insider/projects/'.$project->id.'/delete')}}" class="btn btn-primary btn-sm">Удалить</a>

                                    </div>
                                </div>
                            @endif

                            <h2><strong>{{$project->name}}</strong></h2>
                                <h5>{{$project->short_description}}</h5>

                            <h6>{{$project->description}}</h6>

                        </h5>
                        <p style="margin-top: 15px;">
                        @if ($project->url!='')
                            <h4>
                                <img src="https://png.icons8.com/git/color/24" title="Git"
                                     width="16" height="16"> {{$project->url}}
                            </h4>
                        @endif
                        @if ($project->type!='')
                        <span style="font-size: 15px; margin-top: 15px" class="badge badge-pill badge-success"><i
                                    class="icon ion-ios-arrow-up"></i> {{$project->type}}</span><br>
                            @endif

                    </div>
                </div>
        </div>

        </div>





@endsection
