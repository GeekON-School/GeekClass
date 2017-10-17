@extends('layouts.app')

@section('title')
    GeekClass: "{{$project->name}}"
@endsection

@section('tabs')

@endsection


@section('content')

    <div class="row">
        {{ csrf_field() }}
        <div class="col-md-4">

            <div class="card">
                <img class="card-img-top"
                     src="{{url('/media/'.$project->image)}}"/>
                <div class="card-body">
                    <h4 class="card-title">{{$project->name}}</h4>


                    <p style="margin-top: 15px;">
                    @if ($project->url!='')
                        <p>
                            <img src="https://png.icons8.com/git/color/24" title="Git"
                                 width="16" height="16"> {{$project->url}}
                        </p>
                    @endif
                    @if ($project->type!='')
                        <span style="font-size: 15px; margin-top: 15px" class="badge badge-pill badge-success"><i
                                    class="icon ion-ios-arrow-up"></i> {{$project->type}}</span><br>
                    @endif
                    @if ($user->role=='teacher'|| $is_in_project)

                        <p style="margin-top: 20px"></p>
                        <div class="float-left">
                            <a href="{{url('/insider/projects/'.$project->id.'/edit')}}"
                               class="btn btn-primary btn-sm">Редактировать</a>
                            <a href="{{url('/insider/projects/'.$project->id.'/delete')}}"
                               class="btn btn-primary btn-sm">Удалить</a>

                        </div>

                    @endif

                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <h3 class="card-title">{{$project->name}}</h3>

                    <p>
                        <strong>Короткое описание: {{$project->short_description}}</strong>
                    </p>
                <!--
                    @if ($user->role=='teacher'|| $is_in_project)
                    <div class="float-right">
                        @if ($user->role=='teacher'|| $is_author)
                        <a href="{{url('/insider/projects/'.$project->id.'/add_user')}}"
                                   class="btn btn-primary btn-sm">Добавить участников</a>
                            @endif
                            </div>
                        @endif -->
                    <h4>Участники: </h4>

                    <div class="row">
                        @foreach($project->students as $student)
                            <div class="col-md-4 " style="margin-bottom: 15px;">
                                <div class="card bg-dark text-white" style="height: 250px;">
                                    <div class="card-header"><a style="color:white;"
                                                                href="{{url('/insider/profile/'.$student->id)}}"><i
                                                    class="icon ion-person"></i>&nbsp;{{$student->name}}</a></div>
                                    <div class="card-body"
                                         style="@if ($student->image!=null) background-image: url({{url('/media/'.$student->image)}}); @else  background-image: url(https://api.adorable.io/avatars/250/{{$student->id}}.png);  @endif background-size: cover;">

                                        <p class="card-text"><span style="font-size: 15px;"
                                                                   class="badge badge-pill badge-success"><i
                                                        class="icon ion-ios-arrow-up"></i> {{$student->rank()->name}}</span><br>@if ($student->is_trainee)
                                                <span class="badge badge-pill badge-info">Стажер</span>
                                            @endif
                                            @if ($student->is_teacher)
                                                <span class="badge badge-pill badge-info">Преподаватель</span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <p><strong>Описание:</strong> {{$project->description}}<br></p>

                </div>
            </div>

        </div>

    </div>





@endsection
