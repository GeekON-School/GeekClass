@extends('layouts.app')

@section('content')
    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <h2>Статьи</h2>

        </div>
    </div>
    <div class="row" style="margin-top: 15px;">

        <div class="col-12">
            @if ($tag != "")
                <p style="margin-bottom: 5px; margin-top: 5px;">Показаны результаты по тэгу <strong>{{ $tag->name }}</strong>. <a href="{{'/insider/forum'}}">Все вопросы</a>.</p>
            @endif
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">

        <div class="col-12">
            @foreach ($articles as $article)
                <div class="card">
                    <div class="card-body" style="background-color: rgba(255,255,255,0.9);">
                        <div class="row">
                            <div class="col">
                                <h5 style="margin-top: 15px; font-weight: 300;"
                                    class="card-title">
                                    <a href="{{url('/articles/'.$article->id)}}">{{$article->name}}</a>
                                </h5>
                                <p>
                                    @foreach($article->tags as $tag)
                                        <span class="badge badge-secondary badge-light"
                                              style="font-size: 1.2rem;"><a href="{{url('/insider/forum?tag='.$tag->name)}}">{{$tag->name}}</a></span>
                                    @endforeach
                                </p>
                                <p style="margin-bottom: 0;">
                                    <small class="text-muted">Опубликовано: {{$article->created_at->format('H:i d.m.Y')}}, {{$article->author->name}}</small>
                                </p>
                            </div>
                        </div>


                    </div>
                </div>
            @endforeach
        </div>
    </div>



@endsection
