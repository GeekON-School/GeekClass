@extends('layouts.app')

@section('title')
    GeekClass: Изменение проекта "{{$project->name}}"
@endsection

@section('content')

    <h2>Изменение проекта "{{$project->name}}"</h2>
    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <form method="POST" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Название</label>

                    @if (old('name')!="")
                        <input id="name" type="text" class="form-control" name="name" value="{{old('name')}}" required>
                    @else
                        <input id="name" type="text" class="form-control" name="name" value="{{$project->name}}"
                               required>
                    @endif
                    @if ($errors->has('name'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="short_description">Краткое описание</label>
                    <textarea id="short_description" class="form-control" name="short_description"
                              required>@if (old('short_description')!=""){{old('short_description')}}@else{{$project->short_description}}@endif</textarea>
                    @if ($errors->has('short_description'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('short_description') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea id="description" class="form-control" name="description"
                              required>@if (old('description')!=""){{old('description')}}@else{{$project->description}}@endif</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                    @endif
                </div>
                
                <div class="form-group">
                    <label for="type">Тип проекта</label>

                    @if (old('type')!="")
                        <input id="type" type="text" class="form-control" name="type" value="{{old('type')}}">
                    @else
                        <input id="type" type="text" class="form-control" name="type" value="{{$project->type}}"
                               required>
                    @endif
                    @if ($errors->has('type'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="url">Ссылка на проект</label>

                    @if (old('')!="")
                        <input id="url" type="text" class="form-control" name="url" value="{{old('url')}}">
                    @else
                        <input id="url" type="text" class="form-control" name="url" value="{{$project->url}}"
                               required>
                    @endif
                    @if ($errors->has('url'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                    @endif
                </div>




                <button type="submit" class="btn btn-success">Сохранить</button>
            </form>
        </div>
    </div>
@endsection

