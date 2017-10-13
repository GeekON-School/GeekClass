@extends('layouts.app')

@section('title')
    GeekClass: Изменение курса "{{$course->name}}"
@endsection

@section('content')

    <h2>Изменение курса "{{$course->name}}"</h2>
    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <form method="POST" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Название</label>

                    @if (old('name')!="")
                        <input id="name" type="text" class="form-control" name="name" value="{{old('name')}}" required>
                    @else
                        <input id="name" type="text" class="form-control" name="name" value="{{$course->name}}"
                               required>
                    @endif
                    @if ($errors->has('name'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="git">Git репозиторий</label>

                    @if (old('git')!="")
                        <input id="git" type="text" class="form-control" name="git" value="{{old('git')}}">
                    @else
                        <input id="git" type="text" class="form-control" name="git" value="{{$course->git}}"
                        >
                    @endif
                    @if ($errors->has('git'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('git') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="telegram">Telegram чат</label>

                    @if (old('telegram')!="")
                        <input id="telegram" type="text" class="form-control" name="telegram" value="{{old('telegram')}}">
                    @else
                        <input id="telegram" type="text" class="form-control" name="telegram" value="{{$course->telegram}}">
                    @endif
                    @if ($errors->has('telegram'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('telegram') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="site">Ссылка на описание курса</label>

                    @if (old('site')!="")
                        <input id="site" type="text" class="form-control" name="site" value="{{old('site')}}">
                    @else
                        <input id="site" type="text" class="form-control" name="site" value="{{$course->site}}"
                        >
                    @endif
                    @if ($errors->has('site'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('site') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="image">Ссылка на обложку</label>

                    @if (old('image')!="")
                        <input id="image" type="text" class="form-control" name="image" value="{{old('image')}}">
                    @else
                        <input id="image" type="text" class="form-control" name="image" value="{{$course->image}}"
                        >
                    @endif
                    @if ($errors->has('image'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea id="description" class="form-control" name="description"
                              required>@if (old('description')!=""){{old('description')}}@else{{$course->description}}@endif</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                    @endif
                </div>

            <!--
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="image" class="col-md-4 control-label">Аватар</label>

                            <div class="col-md-8">
                                <input id="image" type="file" class="form-control" name="image"/>

                                @if ($errors->has('image'))
                <span class="help-block error-block">
                    <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                    </div>
                </div>
-->

                <button type="submit" class="btn btn-success">Сохранить</button>
            </form>
        </div>
    </div>
@endsection

