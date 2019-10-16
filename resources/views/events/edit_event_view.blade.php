@extends('layouts.left-menu')

@section('content')
    <div class="row">
        <div class="col">
            <h2>Изменить событие</h2>
            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <div class="form-group required">
                            <label>Тип события</label>
                            <div class="radio">
                                <div><input type="radio" name="type" value="Внешнее" checked="">Внешнее</div>
                                <div><input type="radio" name="type" value="Внутреннее">Внутреннее</div>
                            </div>
                            @if ($errors->has('type'))
                                <span class="help-block error-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group required">
                            <label>Название события</label>
                            <input type="text" name="name" class="form-control" required="" value="{{$event->name}}">
                            @if ($errors->has('name'))
                                <span class="help-block error-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="orgs" style="padding-bottom: 10px;">Организаторы:</label><br>
                            <select class="selectpicker1  form-control" data-live-search="true" id="orgs"
                                    name="orgs[]" multiple data-width="auto">
                                @foreach (\App\User::all() as $user)
                                    <option data-tokens="{{ $user->id }}"
                                            value="{{ $user->id }}">{{$user->name}}</option>
                                @endforeach
                            </select>

                            <script>
                                $('.selectpicker1').selectpicker('val', [{{implode(',', $event->userOrgs->pluck('id')->toArray())}}]);
                            </script>
                        </div>

                        <div class="form-group required">
                            <label>Краткое описание события</label>
                            <input name="short_text" class="form-control" required="" value="{{$event->short_text}}">
                            @if ($errors->has('short_text'))
                                <span class="help-block error-block">
                                        <strong>{{ $errors->first('short_text') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group required">
                            <label>Описание</label>
                            <textarea id="text" class="form-control"
                                      name="text">{{$event->text}}</textarea>
                            @if ($errors->has('text'))
                                <span class="help-block error-block">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group required">
                            <label>Дата</label>
                            <input type="text" name="date" class="date form-control" required="" id="dp1570721390164"
                                   value="{{ $event->date->format("Y-m-d")}}">
                            @if ($errors->has('date'))
                                <span class="help-block error-block">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group required">
                            <label>Время</label>
                            <input type="time" name="time" class="form-control" required="" id="dp1570721390164"
                                   value="{{ $event->date->format("H:i")}}">
                            @if ($errors->has('time'))
                                <span class="help-block error-block">
                                        <strong>{{ $errors->first('time') }}</strong>
                                    </span>
                            @endif

                            <div class="form-group required">
                                <label>Место проведения</label>
                                <input name="location" class="form-control" required="" value="{{$event->location}}">
                                @if ($errors->has('location'))
                                    <span class="help-block error-block">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Ограничение на кол-во студентов</label>
                                <input type="number" name="max_people" class="form-control"
                                       value="{{$event->max_people}}">
                                @if ($errors->has('max_people'))
                                    <span class="help-block error-block">
                                        <strong>{{ $errors->first('max_people') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Сайт мероприятия</label>
                                <input name="site" class="form-control" value="{{$event->site}}">
                                @if ($errors->has('site'))
                                    <span class="help-block error-block">
                                        <strong>{{ $errors->first('site') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Что должны знать студенты</label>
                                <input name="skills" class="form-control" value="{{$event->skills}}">
                                @if ($errors->has('skills'))
                                    <span class="help-block error-block">
                                        <strong>{{ $errors->first('skills') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group row">
                                @foreach($tags as $tag)
                                    @if($tag->id !=1)
                                        <div class="col-md-3">
                                            <div class="card" style="width: 100%; margin-bottom: 10px;">
                                                <div class="card-body">
                                                    <div class="form-check " style="margin-left: 10px;">
                                                        <input type="checkbox" name="tags[]" class="form-check-input"
                                                               value="{{$tag->id}}" id="{{$tag->id}}">
                                                        <label for="{{$tag->id}}"
                                                               class="form-check-label">{{$tag->name}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <input type="submit" value="Добавить" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
        <script>
            var simplemde_description = new EasyMDE({
                spellChecker: false,
                autosave: true,
                element: document.getElementById("text")
            });
        </script>
    </div>
@endsection