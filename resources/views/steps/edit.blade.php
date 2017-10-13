@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s12">
            <h3>Изменение темы: "{{$step->name}}"</h3>
            <form method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Название</label>

                    @if (old('name')!="")
                        <input id="name" type="text" class="form-control" value="{{old('name')}}"
                               name="name" required>
                    @else
                        <input id="name" type="text" class="form-control" value="{{$step->name}}"
                               name="name" required>
                    @endif
                    @if ($errors->has('name'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="start_date">Дата начала</label>
                    @if (old('start_date')!="")
                        <input id="start_date" type="text" class="form-control" value="{{old("start_date")}}"
                               name="start_date"
                               required>
                    @else
                        <input id="start_date" type="text" class="form-control" value="@if ($step->start_date!=null){{$step->start_date->format('Y-m-d')}}@endif"
                               name="start_date"
                               required>
                    @endif
                    @if ($errors->has("start_date"))
                        <span class="help-block error-block">
                                            <strong>{{ $errors->first("start_date") }}</strong>
                                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="description" style="padding-bottom: 10px;">Описание</label>

                    @if (old('description')!="")
                        <textarea id="description" class="materialize-textarea"
                                  name="description">{{old('description')}}</textarea>
                    @else
                        <textarea id="description" class="materialize-textarea"
                                  name="description">{{$step->description}}</textarea>
                    @endif
                    @if ($errors->has('description'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="theory" style="padding-bottom: 10px;">Теоретический материал</label>
                    @if (old('theory')!="")
                        <textarea id="theory" class="form-control"
                                  name="theory">{{old('theory')}}</textarea>
                    @else
                        <textarea id="theory" class="form-control"
                                  name="theory">{{$step->theory}}</textarea>
                    @endif

                    @if ($errors->has('theory'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('theory') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="notes" style="padding-bottom: 10px;">Комментарий для преподавателя</label>
                    @if (old('notes')!="")
                        <textarea id="notes" class="form-control"
                                  name="notes">{{old('notes')}}</textarea>
                    @else
                        <textarea id="notes" class="form-control"
                                  name="notes">{{$step->notes}}</textarea>
                    @endif

                    @if ($errors->has('notes'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('notes') }}</strong>
                                    </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-success">Сохранить</button>
            </form>
            <script>
                var simplemde_description = new SimpleMDE({
                    spellChecker: false,
                    autosave: true,
                    element: document.getElementById("description")
                });
                var simplemde_theory = new SimpleMDE({spellChecker: false,autosave: true, element: document.getElementById("theory")});
                var simplemde_notes = new SimpleMDE({spellChecker: false,autosave: true, element: document.getElementById("notes")});
            </script>
        </div>
    </div>
    </div>
    </div>
@endsection
