@extends('layouts.app')

@section('title')
    GeekClass: "{{$article->name}}"
@endsection

@section('tabs')

@endsection


@section('content')
    <div id="root">

        <h2 style="margin: 20px;"><a class="back-link" href="{{url('/articles')}}"><i
                        class="icon ion-chevron-left"></i></a>&nbsp;{{$article->name}}</h2>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div style="float: left; width: 100%; padding-left: 5px;" class="col-auto">
                        <div class="row">
                            <div class="col col-md-9">
                                @if ($article->author->image)
                                    <img src="{{url('/media/'.$article->author->image)}}"
                                         style="width: 50px; margin: 0;margin-right: 10px;"
                                         class="img-thumbnail" align="left">
                                @else

                                    <img src="https://api.adorable.io/avatars/250/{{$article->author->id}}.png"
                                         style="width: 50px; margin: 0;margin-right: 10px;"
                                         class="img-thumbnail" align="left">
                                @endif
                                <strong><a href="#" target="_blank"
                                           style="color: black">{{$article->author->name}}</a></strong><br>
                                <span class="badge badge-pill badge-success"><i
                                            class="icon ion-ios-arrow-up"></i> {{$article->author->rank()->name}}</span>

                                @if ($article->author->is_trainee)
                                    <span class="badge badge-pill badge-info">Стажер</span>
                                @endif
                                @if ($article->author->is_teacher)
                                    <span class="badge badge-pill badge-info">Преподаватель</span>
                                @endif
                            </div>
                            <div class="col col-md-3">
                        <span class="float-right lead">
                            @if (\Auth::check())
                                @if ($article->author->id == \Auth::User()->id or \Auth::User()->role=="admin")
                                    <a href="{{url("/articles/".$article->id."/edit")}}"
                                       class="btn btn-sm btn-success"
                                       style="margin-right: 5px;margin-left: 5px;"><i class="icon ion-edit"></i></a>

                                    <a href="{{url("/articles/".$article->id."/delete")}}"
                                       onclick="return confirm('Вы уверены?')" class="btn btn-sm btn-danger"
                                       style="margin-right: 5px;"><i class="icon ion-close-round"></i></a>
                                @endif
                            @endif</span>
                            </div>
                        </div>

                        <div style="margin-top: 15px;">
                            @parsedown($article->anounce)
                        </div>

                        <div style="margin-top: 15px;">
                            @parsedown($article->text)
                        </div>

                        @foreach($article->tags as $tag)
                            <span class="badge badge-secondary badge-light"><a target="_blank"
                                                                               href="{{url('/insider/forum?tag='.$tag->name)}}">{{$tag->name}}</a></span>
                        @endforeach


                    </div>
                </div>

            </div>
        </div>

    </div>





@endsection
