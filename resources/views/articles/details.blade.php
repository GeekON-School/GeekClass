@extends('layouts.full')

@section('title')
    GeekClass: "{{$article->name}}"
@endsection

@section('tabs')

@endsection


@section('content')
    <div id="root">

        <h1 style="margin-top: 20px; margin-bottom: 10px;">{{$article->name}}</h1>

        @foreach($article->tags as $tag)
            <span class="badge badge-secondary badge-light"><a target="_blank"
                                                               href="{{url('/articles?tag='.$tag->name)}}">{{$tag->name}}</a></span>
        @endforeach

        <div class="row" style="margin-top: 25px;">
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
                        <h5><a href="{{url('/insider/profile/'.$article->author->id)}}">{{ $article->author->name }}</a>
                        </h5>
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




            </div>
        </div>


    </div>





@endsection
