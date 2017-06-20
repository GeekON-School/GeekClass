@extends('layouts.app')

@section('title')
    GeekClass: Добавление курса
@endsection

@section('content')
    <div class="row" style="padding-top: 20px;">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Создание курса</span>
                    <form method="POST" class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="input-field col s12">
                            <input id="name" type="text" class="validate" name="name"
                                   value="{{old('name')}}" required>
                            <label for="name">Название</label>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="input-field col s12">
                            <textarea id="description" class="materialize-textarea" name="description"
                                      required>{{old('description')}}</textarea>
                            <label for="description">Описание</label>
                            @if ($errors->has('description'))
                                <span class="help-block">
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
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        -->

                                <button type="submit" class="btn btn-success">Создать</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
