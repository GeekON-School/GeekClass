@extends('layouts.app')

@section('content')
    <h2>Создание урока</h2>

    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <form method="POST" class="form-horizontal">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name">Название урока</label>

                    <input id="name" type="text" class="form-control" value="{{old('name')}}"
                           name="name"
                           required>

                    @if ($errors->has('name'))
                        <span class="help-block error-block"><strong>{{ $errors->first('name') }}</strong></span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has("start_date") ? ' has-error' : '' }}">
                    <label for="start_date">Дата начала</label>

                    <input id="start_date" type="text" class="form-control" value="{{old("start_date")}}"
                           name="start_date"
                           required>

                    @if ($errors->has("start_date"))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first("start_date") }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="description" style="padding-bottom: 10px;">Описание урока</label>

                    <textarea id="description" class="materialize-textarea"
                              name="description">{{old('description')}}</textarea>

                    @if ($errors->has('description'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-success">Создать</button>
                    </div>
                </div>
            </form>
            <script>
                var simplemde_description = new SimpleMDE({
                    spellChecker: false,
                    element: document.getElementById("description")
                });
            </script>
        </div>
    </div>
@endsection
