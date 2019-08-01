@extends('layouts.full')

@section('content')
    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <h2>Статьи</h2>
        </div>
        <div class="col">
            @if (\Auth::check() and (\Auth::User()->role=='teacher' || \Auth::User()->role=='admin'))
                <ul class="nav nav-pills float-right" id="ideasTabs" role="tablist">
                    <li class="nav-item" style="margin-left: 5px;">
                        <a class="btn btn-success btn-sm nav-link" href="{{url('/articles/create/')}}"><i
                                    class="icon ion-plus-round"></i>&nbsp;Написать</a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">

        <div class="col-12">
            @if ($tag != "")
                <p style="margin-bottom: 5px; margin-top: 5px;">Показаны результаты по тэгу
                    <strong>{{ $tag->name }}</strong>. <a href="{{'/insider/forum'}}">Все вопросы</a>.</p>
            @endif
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">

        @foreach ($articles as $article)

            <div class="col-md-12">
                <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-primary">
                            @foreach($article->tags as $tag)
                                <span class="badge badge-secondary badge-light"><a href="{{url('/insider/forum?tag='.$tag->name)}}">{{$tag->name}}</a></span>
                            @endforeach
                        </strong>


                        <h3 class="mb-0">{{$article->name}}</h3>
                        <div class="mb-1 text-muted"
                             style="margin-top: 5px;">{{$article->created_at->format('H:i d.m.Y')}}, <a href="{{url('/insider/profile/'.$article->author->id)}}">{{ $article->author->name }}</a></div>
                        <div class="card-text mb-auto" style="margin-top: 15px;">@parsedown($article->anounce)</div>

                        <a href="{{url('/articles/'.$article->id)}}" style="margin-top: 10px;" class="stretched-link">Читать
                            полностью...</a>
                    </div>

                    <div class="col-auto d-none d-lg-block">
                        <svg class="bd-placeholder-img" width="200" height="100%" xmlns="http://www.w3.org/2000/svg"
                             preserveAspectRatio="xMidYMid slice" focusable="false" role="img"
                             aria-label="Placeholder: Thumbnail"><title>Placeholder</title>
                            <rect width="100%" height="100%" fill="#55595c"/>
                            <text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                        </svg>
                    </div>
                </div>
            </div>



        @endforeach
    </div>



@endsection
