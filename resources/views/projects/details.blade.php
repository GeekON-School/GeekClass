@extends('layouts.app')

@section('title')
    GeekClass: "{{$project->name}}"
@endsection

@section('tabs')

@endsection

@section('content')
    <div class="row">
        <div class="col">
            <h2>{{$project->name}}</h2>
            <p>{{$project->description}}</p>
        </div>
        @if ($user->role=='teacher'|| $guest->id==$user->id)
            <div class="col">
                <div class="float-right">
                    <a href="{{url('/insider/projects/'.$project->id.'/edit')}}"
                       class="btn btn-primary btn-sm">Редактировать</a>
                    <a href="{{url('/insider/projects/'.$project->id.'/delete')}}" class="btn btn-primary btn-sm">Удалить</a>

                </div>
            </div>
        @endif
        </div>





@endsection
