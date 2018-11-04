@extends('layouts.app')

@section('title')
    GeekClass: "{{$project->name}}"
@endsection

@section('tabs')

@endsection


@section('content')

    <div class="row">
        {{ csrf_field() }}

        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <div class="row">
                    <div class="col col-md-auto">
                        <h3 class="card-title">{{$project->name}}</h3>
                    </div>
                    <div class="col">

                        @if ($user->role=='teacher'|| $is_in_project)
                            <div class="float-right">
                                <a href="{{url('/insider/projects/'.$project->id.'/edit')}}"
                                   class="btn btn-primary btn-sm">Редактировать</a>
                                <a href="{{url('/insider/projects/'.$project->id.'/delete')}}"
                                   class="btn btn-primary btn-sm"  onclick="return confirm('Вы уверены?')">Удалить</a>

                            </div>

                        @endif
                    </div>
                    </div>

                    <p>
                        <strong>{{$project->short_description}}</strong>

                    </p>
                <!--
                    @if ($user->role=='teacher'|| $is_in_project)
                    <div class="float-right">
                        @if ($user->role=='teacher'|| $is_author)
                        <a href="{{url('/insider/projects/'.$project->id.'/add_user')}}"
                                   class="btn btn-primary btn-sm">Добавить студентов</a>
                            @endif
                            </div>
                        @endif -->
                    <div class="row">
                        @foreach($project->students as $student)
                            <div class="col-md-4 col-lg-3 col-xl-2 col-sm-6" style="margin-bottom: 15px;">
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
                    @if ($project->description != "")
                    @parsedown($project->description)</p>
                    @endif
                </div>
            </div>

        </div>

    </div>





@endsection
