
@extends('layouts.app')
nbkmb
@section('title')
    GeekClass: Добавление проекта
@endsection

@section('content')
    <h2>Создание проекта</h2>
    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <form method="POST" class="form-horizontal" enctype="multipart/form-data">

                <div class="form-group">
                    {{ csrf_field() }}
                    <label for="name">Название</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{old('name')}}" required>
                    @if ($errors->has('name'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea id="description"  class="form-control"  name="description" required>{{old('description')}}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="projectType">Тип</label>
                    <textarea id="projectType"  class="form-control"  name="projectType">{{old('projectType')}}</textarea>
                    @if ($errors->has('projectType'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('projectType') }}</strong>
                                    </span>
                    @endif
                </div>





                <button type="submit" class="btn btn-success">Создать</button>
            </form>
        </div>
    </div>
@endsection
