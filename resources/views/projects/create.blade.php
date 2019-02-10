
@extends('layouts.app')

@section('title')
    GeekClass: Добавление проекта
@endsection

@section('content')
    <h2>Создание проекта</h2>
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
                    <label for="short_description">Краткое описание</label>
                    <input id="short_description"  class="form-control"  name="short_description" required>{{old('short_description')}}</input>
                    @if ($errors->has('short_description'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('short_description') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea id="description"  class="form-control"  name="description">{{old('description')}}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                    {!! \NoCaptcha::display() !!}
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block">
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                        </span>
                    @endif
                </div>






                <input type="submit" class="btn btn-success" value="Создать"/>
            </form>
        </div>
        <script>
            var simplemde_description = new EasyMDE({
                spellChecker: false,
                autosave: true,
                element: document.getElementById("description")
            });
        </script>
    </div>
@endsection
