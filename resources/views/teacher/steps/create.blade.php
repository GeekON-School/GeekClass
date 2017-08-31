@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Создание темы</div>

                <div class="panel-body">
                    <form method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Название</label>

                            <div class="col-md-8">
                                <input id="name" type="name" class="form-control" value="{{old('name')}}" name="name"
                                       required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Описание</label>
                            <div class="col-md-8">
                                <textarea id="description" class="form-control"
                                          name="description">{{old('description')}}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
                            <label for="notes" class="col-md-4 control-label">Комментарий для преподавателя</label>
                            <div class="col-md-8">
                                <textarea id="notes" class="form-control" name="notes">{{old('notes')}}</textarea>

                                @if ($errors->has('notes'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('notes') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('theory') ? ' has-error' : '' }}">
                            <label for="theory" class="col-md-4 control-label">Теоретический материал</label>
                            <div class="col-md-8">
                                <textarea id="theory" class="form-control" name="theory"
                                          rows="20">{{old('theory')}}</textarea>

                                @if ($errors->has('theory'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('theory') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-success">Создать</button>
                            </div>
                        </div>
                    </form>
                    <script>
                        var simplemde_description = new SimpleMDE({spellChecker: false,element: document.getElementById("description")});
                        var simplemde_notes = new SimpleMDE({spellChecker: false,element: document.getElementById("notes")});
                        var simplemde_theory = new SimpleMDE({spellChecker: false,element: document.getElementById("theory")});
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
