@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12">
            <h3>Изменение темы: "{{$step->name}}"</h3>
            <form method="POST">
                {{ csrf_field() }}
                <div class="row">
                    <div class="input-field col s12">
                        <label for="name">Название</label>

                        @if (old('name')!="")
                            <input id="name" type="text" class="validate" value="{{old('name')}}"
                                   name="name" required>
                        @else
                            <input id="name" type="text" class="validate" value="{{$step->name}}"
                                   name="name" required>
                        @endif
                        @if ($errors->has('name'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <label for="description" style="padding-bottom: 10px;">Описание</label>

                        @if (old('description')!="")
                            <textarea id="description" class="materialize-textarea"
                                      name="description">{{old('description')}}</textarea>
                        @else
                            <textarea id="description" class="materialize-textarea"
                                      name="description">{{$step->description}}</textarea>
                        @endif
                        @if ($errors->has('description'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <label for="notes" style="padding-bottom: 10px;">Комментарий для преподавателя</label>
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
                <div class="row">
                    <div class="input-field col s12">
                        <label for="theory" style="padding-bottom: 10px;">Теоретический материал</label>
                        @if (old('theory')!="")
                            <textarea id="theory" class="form-control"
                                      name="theory">{{old('theory')}}</textarea>
                        @else
                            <textarea id="theory" class="form-control"
                                      name="theory">{{$step->theory}}</textarea>
                        @endif

                        @if ($errors->has('theory'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('theory') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Создать</button>
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
