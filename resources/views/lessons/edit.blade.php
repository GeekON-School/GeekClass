@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12">
            <h3>Изменение урока: "{{$lesson->name}}"</h3>
            <form method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Название</label>

                    @if (old('name')!="")
                        <input id="name" type="text" class="form-control" value="{{old('name')}}"
                               name="name" required>
                    @else
                        <input id="name" type="text" class="form-control" value="{{$lesson->name}}"
                               name="name" required>
                    @endif
                    @if ($errors->has('name'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>


                <div class="form-group">
                    <label for="description" style="padding-bottom: 10px;">Описание</label>
                    @if (old('description')!="")
                        <textarea id="description" class="form-control"
                                  name="description">{{old('description')}}</textarea>
                    @else
                        <textarea id="description" class="form-control"
                                  name="description">{{$lesson->description}}</textarea>
                    @endif

                    @if ($errors->has('description'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                    @endif
                </div>

                <hr>

                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="open" value="yes" @if ($lesson->is_open) checked @endif>
                        Сделать занятие открытым
                    </label>
                </div>


                <button type="submit" class="btn btn-success">Сохранить</button>
            </form>
            <script>
                var simplemde_description = new SimpleMDE({
                    spellChecker: false,
                    autosave: true,
                    element: document.getElementById("description")
                });
            </script>
        </div>
    </div>
@endsection
