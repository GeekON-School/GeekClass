@extends('layouts.app')

@section('content')
    <div class="container">
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
                                    @if (old('name')!="")
                                        <input id="name" type="name" class="form-control" value="{{old('name')}}" name="name" required>
                                    @else
                                        <input id="name" type="name" class="form-control" value="{{$step->name}}" name="name" required>
                                    @endif
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
                                    @if (old('description')!="")
                                        <textarea id="description" class="form-control" name="description">{{old('description')}}</textarea>
                                    @else
                                        <textarea id="description" class="form-control" name="description">{{$step->description}}</textarea>
                                    @endif
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
                                    @if (old('notes')!="")
                                        <textarea id="notes" class="form-control" name="notes">{{old('notes')}}</textarea>
                                    @else
                                        <textarea id="notes" class="form-control" name="notes">{{$step->notes}}</textarea>
                                    @endif

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
                                    @if (old('theory')!="")
                                        <textarea id="theory" class="form-control" name="theory">{{old('theory')}}</textarea>
                                    @else
                                        <textarea id="theory" class="form-control" name="theory">{{$step->theory}}</textarea>
                                    @endif

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
                            var simplemde_description = new SimpleMDE({ element: document.getElementById("description")});
                            var simplemde_notes = new SimpleMDE({ element: document.getElementById("notes")});
                            var simplemde_theory = new SimpleMDE({ element: document.getElementById("theory")});
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
