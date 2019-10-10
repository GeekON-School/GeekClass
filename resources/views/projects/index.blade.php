@extends('layouts.left-menu')

@section('content')
    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <h2>Проекты</h2>
        </div>
        <div class="col">
            <ul class="nav nav-tabs nav-fill" id="ideasTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="projects-tab" data-toggle="tab" href="#projects" role="tab"
                       aria-controls="projects" aria-selected="true">Мои проекты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="all_projects-tab" data-toggle="tab" href="#all_projects" role="tab"
                       aria-controls="all_projects" aria-selected="false">Все проекты</a>
                </li>
                <li class="nav-item" style="margin-left: 5px;">
                    <a class="btn btn-success btn-sm nav-link" style="color: white;"  href="{{url('/insider/projects/create/')}}"><i
                                class="icon ion-plus-round" style="color: white;"></i>&nbsp;Создать</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content" id="ideas" style="margin-top: 15px;">
        <div class="tab-pane fade show active" id="projects" role="tabpanel" aria-labelledby="projects">
            <div class="row">
                <div class="col-12">
                    @if ($user->projects->count() == 0)
                        <div class="jumbotron">
                            <h1 class="display-4">Вместе веселее!</h1>
                            <p class="lead" style="margin-top: 15px;">Часто большие задачи гораздо приятнее решать в небольшой команде. В этом разделе вы можете создать командный проект, добавить участников в команду и привязать проект к одной из учебных задач. А преподаватель сможет оценить всех участников команды одновременно. Попробуйте!</p>
                            <a class="btn btn-primary btn-lg" style="margin-top: 15px;"
                               href="{{url('/insider/projects/create/')}}"
                               role="button">Создать проект</a>
                        </div>
                    @endif

                    <div class="card-deck">
                        @foreach($user->projects as $project)

                            <div class="card" style="min-width: 40%; border-left: 3px solid #28a745;">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1"><a  href="{{url('/insider/projects/'.$project->id)}}">{{$project->name}}</a></h5>
                                            {{$project->short_description}}
                                        </div>
                                        @if ($project->url!=null)
                                        <img height="75px"
                                             src="@if ($project->url!=null){{$project->url}}@endif"
                                             class="ml-3">
                                            @endif
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="all_projects" role="tabpanel" aria-labelledby="all_projects">
            <div class="row">
                <div class="col-12">
                    <div class="card-deck">
                        @foreach($projects as $project)

                            <div class="card" style="min-width: 40%;border-left: 3px solid #28a745;">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1"><a href="{{url('/insider/projects/'.$project->id)}}"> {{$project->name}}</a></h5>
                                            {{$project->short_description}}
                                        </div>
                                        @if ($project->url!=null)
                                            <img height="75px"
                                                 src="@if ($project->url!=null){{$project->url}}@endif"
                                                 class="ml-3">
                                        @endif
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
