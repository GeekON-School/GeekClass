@extends('layouts.app')

@section('title')
    GeekClass: "{{$idea->name}}"
@endsection

@section('tabs')

@endsection


@section('content')

    <div class="row">
        {{ csrf_field() }}

        <div class="col-md-12">
            @if (!$idea->is_approved and $user->id == $idea->author->id)
                <div class="alert alert-warning" role="alert">
                    Ваша идея ожидает утверждения. Скоро один из преподавателей ознакомится с ней, утвердит ее или предложит доработки.
                </div>
            @endif
            <div class="card">

                <div class="card-body">
                    <div class="row">
                        <div class="col col-md-auto">
                            <h3 class="card-title" style="line-height: 50px; font-weight: 200;">{{$idea->name}}
                                &nbsp;<img src="https://img.icons8.com/color/48/000000/idea-sharing.png">
                            </h3>

                            @if ($idea->is_approved) <p class="text-muted">
                                Автор идеи - <a
                                        href="{{url('insider/profile/'.$idea->author->id)}}">{{$idea->author->name}}</a>
                            </h4> @endif

                        </div>
                        <div class="col">

                            @if ($user->role=='teacher'|| ($user->id == $idea->author->id && !$idea->is_approved))
                                <div class="float-right">
                                    @if ($user->role=='teacher' and !$idea->is_approved)
                                        <a href="{{url('/insider/ideas/'.$idea->id.'/approve')}}"
                                           class="btn btn-primary btn-sm">Утвердить</a>
                                        <a href="{{url('/insider/ideas/'.$idea->id.'/decline')}}"
                                           class="btn btn-warning btn-sm">Попросить доработать</a>
                                    @endif
                                    <a href="{{url('/insider/ideas/'.$idea->id.'/edit')}}"
                                       class="btn btn-success btn-sm"><i class="icon ion-android-create"></i></a>
                                    <a href="{{url('/insider/ideas/'.$idea->id.'/delete')}}"
                                       class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены?')"><i
                                                class="ion-close-round"></i></a>

                                </div>

                            @endif
                        </div>
                    </div>
                    <blockquote class="bd-callout bd-callout-info">
                        <p class="text-muted">{{$idea->short_description}}</p>
                    </blockquote>
                    <div class="markdown">

                        @parsedown($idea->description)
                    </div>
                </div>
            </div>

        </div>

    </div>





@endsection
