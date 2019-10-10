@extends('layouts.left-menu')

@section('title')
    GeekClass: Редактирование поста
@endsection

@section('content')
    <h2>Изменение статьи...</h2>
    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        {{ csrf_field() }}


                        <div class="form-group">

                            <label for="name">Название</label>
                            <input id="name" type="text" class="form-control" name="name"
                                   value="@if (old('name')!=''){{old('name')}}@else{{$article->name}}@endif"
                                   required>
                            @if ($errors->has('name'))
                                <span class="help-block error-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">

                            <label for="image">Картинка</label>
                            <input id="image" type="text" class="form-control" name="image"
                                   value="@if (old('image')!=''){{old('image')}}@else{{$article->image}}@endif"
                                   required>
                            @if ($errors->has('image'))
                                <span class="help-block error-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="form-group">
                            <label for="anounce">Текст</label>
                            <textarea id="anounce" class="form-control"
                                      name="anounce">@if (old('anounce')!=''){{old('anounce')}}@else{{$article->anounce}}@endif</textarea>
                            @if ($errors->has('anounce'))
                                <span class="help-block error-block">
                                        <strong>{{ $errors->first('anounce') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="text">Текст</label>
                            <textarea id="text" class="form-control"
                                      name="text">@if (old('text')!=''){{old('text')}}@else{{$article->text}}@endif</textarea>
                            @if ($errors->has('text'))
                                <span class="help-block error-block">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                            @endif
                        </div>


                        <div class="form-group">
                            <label for="tags">Теги</label>
                            <p class="text-muted" style="margin-top: 5px;">Перечислите тэги вашей темы через точку с
                                запятой <strong>без пробелов</strong>.</p>

                            <input id="tags" type="text" placeholder="python;типы данных;list;" class="form-control"
                                   name="tags"
                                   value="@if (old('name')!=''){{old('tags')}}@else{{ $article->tags->pluck('name')->implode(';') }}@endif">
                            @if ($errors->has('tags'))
                                <span class="help-block error-block">
                                        <strong>{{ $errors->first('tags') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <input type="submit" class="btn btn-success" value="Сохранить"/>
                    </form>
                </div>
            </div>
        </div>
        <script>
            var simplemde_text = new EasyMDE({
                spellChecker: false,
                autosave: true,
                element: document.getElementById("text")
            });

            var simplemde_anounce = new EasyMDE({
                spellChecker: false,
                autosave: true,
                element: document.getElementById("anounce")
            });
        </script>
    </div>
@endsection
