@extends('layouts.full')

@section('title')
    GeekClass: "{{$article->name}}"
@endsection

@section('tabs')

@endsection


@section('content')



    <div class="row">
        <div class="col-12">
            @if ($article->image)
                <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark"
                     style='background-size: contain;background-image: url("{{url($article->image)}}"); margin-bottom: 15px;'>
                    <div class="col-md-6 px-0">
                        @foreach($article->tags as $tag)

                            @if (\Auth::check())
                                <span class="badge badge-secondary badge-light">
                                <a target="_blank"
                                   href="{{url('/insider/articles?tag='.$tag->name)}}">{{$tag->name}}</a></span>
                            @else
                                <span class="badge badge-secondary badge-light">
                                <a target="_blank" href="{{url('/articles?tag='.$tag->name)}}">{{$tag->name}}</a></span>
                            @endif
                        @endforeach
                        <h1 class="display-4">{{$article->name}}</h1>

                    </div>
                </div>
            @else
                @foreach($article->tags as $tag)
                    <span class="badge badge-secondary badge-light"><a target="_blank"
                                                                       href="{{url('/articles?tag='.$tag->name)}}">{{$tag->name}}</a></span>
                @endforeach
                <h1 class="display-4">{{$article->name}}</h1>
            @endif
        </div>
    </div>

    @if (\Auth::check() && (\Auth::User()->role == 'admin' || \Auth::User()->id == $article->author->id))
        <div class="row">
            @if (\Auth::User()->role == 'admin')
                <div class="col-12" style="margin-right: 15px;">
                    <a href="{{url('/insider/articles/'.$article->id.'/delete')}}"
                       class="float-right"
                       style="margin-right: 5px;margin-left: 5px;"><i class="icon ion-close-round"></i> удалить</a>
                    <a href="{{url('/insider/articles/'.$article->id.'/edit')}}"
                       class="float-right"
                       style="margin-right: 5px;margin-left: 5px;"><i class="icon ion-edit"></i> изменить</a>

                </div>
            @endif
        </div>
    @endif


    <div class="row" style="margin-top: 15px;">
        <div class="col-12">
            <div style="float: left; width: 100%; padding-left: 5px;" class="col-auto">
                <div class="row">
                    <div class="col" style="width: 85px; max-width: 85px;">
                        @if ($article->author->image!=null)
                            <div class="mr-3 rounded-circle img-circle"
                                 style='background-image: url("{{url('/media/'.$article->author->image)}}");'>
                            </div>
                        @else
                            <div class="mr-3 rounded-circle img-circle"
                                 style='background-image: url("http://api.adorable.io/avatars/256/{{$article->author->id}}");'>
                            </div>
                        @endif
                    </div>
                    <div class="col-auto" style="width: calc(100% - 100px); max-width: calc(100% - 100px)">
                        @if (\Auth::check())
                            <h5>
                                <a href="{{url('/insider/profile/'.$article->author->id)}}">{{ $article->author->name }}</a>
                            </h5>
                        @else
                            <h5>{{ $article->author->name }}</h5>
                        @endif
                        <p><a tabindex="0" data-toggle="popover" data-trigger="focus" title="Ранги"
                              data-html="true"
                              data-content="{{\App\Rank::getRanksListHTML($article->author->rank())}}"><span
                                        style="font-size: 13px;" class="badge badge-pill badge-success"><i
                                            class="icon ion-ios-arrow-up"></i> {{$article->author->rank()->name}}</span></a>

                            @if ($article->author->is_trainee)
                                <span style="font-size: 13px;" class="badge badge-pill badge-info">Стажер</span>
                            @endif
                            @if ($article->author->is_teacher)
                                <span style="font-size: 13px;"
                                      class="badge badge-pill badge-info">Преподаватель</span>
                            @endif</p>
                    </div>
                </div>
                <div style="margin-top: 15px;" class="markdown markdown-big">
                    @parsedown($article->anounce)
                </div>
                <hr>
                <div style="margin-top: 15px;" class="markdown markdown-big">
                    @parsedown($article->text)
                </div>
                @if (\Auth::check() && \Auth::User()->role != 'novice')
                    <a href="{{url('insider/articles')}}">Назад</a>
                @else
                    <a href="{{url('articles')}}">Назад</a>
                @endif

            </div>
        </div>
    </div>






@endsection
