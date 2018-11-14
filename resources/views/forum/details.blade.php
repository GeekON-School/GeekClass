@extends('layouts.app')

@section('title')
    GeekClass: "{{$thread->name}}"
@endsection

@section('tabs')

@endsection


@section('content')
    <h2 style="margin: 20px;"><a class="back-link" href="{{url('/insider/forum/')}}"><i
                    class="icon ion-chevron-left"></i></a>&nbsp;{{$thread->name}}</h2>

    @foreach($thread->orderedPosts() as $post)
        <div class="card">
            <div class="card-body markdown @if (!$post->is_question and $post->getVotes()>=3) alert-success @endif">
                <p style="line-height: 50px; max-width: 96%;">
                    @if ($post->user->image)
                        <img src="{{url('/media/'.$post->user->image)}}"
                             style="width: 50px; margin: 0;margin-right: 10px;"
                             class="img-thumbnail" align="left">
                    @else

                        <img src="https://api.adorable.io/avatars/250/{{$user->id}}.png"
                             style="width: 50px; margin: 0;margin-right: 10px;"
                             class="img-thumbnail" align="left">
                    @endif
                    <strong>{{$post->user->name}}</strong> <span class="float-right lead">
                    @if ($post->user != $user and $post->checkVote($user))
                            <a href="{{url('/insider/forum/'.$thread->id.'/upvote/'.$post->id)}}"
                               class="btn btn-sm btn-success"
                               style="margin-right: 5px;" onclick="return confirm('Вы уверены?');"><i
                                        class="icon ion-ios-plus-empty"></i></a>
                            {{$post->getVotes()}}
                            <a href="{{url('/insider/forum/'.$thread->id.'/downvote/'.$post->id)}}"
                               class="btn btn-sm btn-danger"
                               style="margin-right: 5px;margin-left: 5px;" onclick="return confirm('Вы уверены?');"><i
                                        class="icon ion-ios-minus-empty"></i></a>
                        @else
                            {{$post->getVotes()}}
                        @endif
                        @if ($post->user == $user || $user->role=='teacher')
                            <a href="{{url('/insider/forum/'.$thread->id.'/edit/'.$post->id)}}"
                               class="btn btn-sm btn-success"
                               style="margin-right: 5px;margin-left: 5px;"><i class="icon ion-edit"></i></a>
                            @if (!$post->is_question)
                                <a href="{{url('/insider/forum/'.$thread->id.'/delete/'.$post->id)}}"
                                   onclick="return confirm('Вы уверены?')" class="btn btn-sm btn-danger"
                                   style="margin-right: 5px;"><i class="icon ion-close-round"></i></a>
                            @endif
                        @endif
                </span>
                </p>
                <div class="@if (!$post->is_question and $post->getVotes()<-2)text-muted @endif">
                    @parsedown($post->text)
                </div>
                <hr>
                @foreach($post->comments as $comment)
                    <p><strong>{{$comment->user->name}}:</strong> {{$comment->text}}</p>
                @endforeach


                <form action="{{url('/insider/forum/'.$thread->id.'/comment/'.$post->id)}}" method="post"
                      style="margin-bottom: 0px;">
                    {{csrf_field()}}
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="comment{{$post->id}}">Новый комментарий:</label>
                        <textarea class="form-control" id="comment{{$post->id}}" rows="2" name="text"></textarea>
                        <input type="submit" value="Уточнить" class="btn btn-info btn-sm" style="margin-top: 5px;"/>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <div>
        <h5 class="card-title">Ответить:</h5>

        <p class="text-muted">Опишите ваш ответ максимально точно и подробно, по возможности, приведите примеры кода.
            Для разметки текста используется markdown, описание - <a target="_blank"
                                                                     href="https://simplemde.com/markdown-guide">тут</a>.
        </p>

        <form action="{{url('/insider/forum/'.$thread->id.'/answer')}}" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <textarea class="form-control" id="answer" name="text">{{old('text')}}</textarea>
                @if ($errors->has('text'))
                    <span class="help-block error-block">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                @endif
            </div>

            <div class="form-group">
                <p style="margin-top: 5px;">Перед отправкой еще раз проверьте правильность, точность и грамотность
                    вашего ответа. Кстати, если участники сочтут ответ хорошим и проголосуют за него более двух раз, вы
                    получите несколько GC.</p>

                <input type="submit" class="btn btn-success btn-lg" value="Отправить ответ"/>
            </div>
        </form>
    </div>

    <script>
        var simplemde_text = new SimpleMDE({
            spellChecker: false,
            autosave: true,
            element: document.getElementById("answer")
        });
    </script>




@endsection
