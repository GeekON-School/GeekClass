
@extends('layouts.app')

@section('title')
    GeekClass: Добавление проекта
@endsection

@section('content')
    <h2>Новый вопрос...</h2>
    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <form method="POST" class="form-horizontal" enctype="multipart/form-data">

                <div class="form-group">
                    {{ csrf_field() }}
                    <label for="name">Название</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{old('name')}}" required>
                    @if ($errors->has('name'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="text">Текст вопроса</label>
                    <textarea id="text"  class="form-control"  name="text">{{old('text')}}</textarea>
                    @if ($errors->has('text'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    {{ csrf_field() }}
                    <label for="tags">Теги</label>
                    <input id="tags" type="text" class="form-control" name="tags" value="{{old('tags')}}" required>
                    @if ($errors->has('tags'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('tags') }}</strong>
                                    </span>
                    @endif
                </div>


                <input type="submit" class="btn btn-success" value="Задать вопрос"/>
            </form>
        </div>
        <script>
            var simplemde_text= new SimpleMDE({
                spellChecker: false,
                autosave: true,
                element: document.getElementById("text")
            });
        </script>
    </div>
@endsection
