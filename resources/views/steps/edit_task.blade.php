@extends('layouts.app')

@section('title')
    GeekClass: Изменение задачи "{{$task->name}}"
@endsection

@section('content')

    <h2>Изменение задачи "{{$task->name}}"</h2>
    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <form method="POST" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Название</label>

                    @if (old('name')!="")
                        <input id="name" type="text" class="form-control" name="name" value="{{old('name')}}" required>
                    @else
                        <input id="name" type="text" class="form-control" name="name" value="{{$task->name}}"
                               required>
                    @endif
                    @if ($errors->has('name'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('max_mark') ? ' has-error' : '' }}">
                    <label for="max_mark">Максимальный балл</label>

                        @if (old('max_mark')!="")
                            <input type="text" name="max_mark" class="form-control" id="max_mark" value="{{old('name')}}" required/>
                        @else
                            <input type="text" name="max_mark" class="form-control" id="max_mark" value="{{$task->max_mark}}" required/>
                        @endif

                        @if ($errors->has('max_mark'))
                            <span class="help-block error-block">
                                        <strong>{{ $errors->first('max_mark') }}</strong>
                                    </span>
                        @endif

                </div>

                <div class="form-group">
                    <label for="text">Текст</label>
                    <textarea id="text" class="form-control" name="text"
                              required>@if (old('text')!=""){{old('text')}}@else{{$task->text}}@endif</textarea>
                    @if ($errors->has('text'))
                        <span class="help-block error-block">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                    @endif
                </div>



                <button type="submit" class="btn btn-success">Сохранить</button>
            </form>
        </div>
    </div>

    <script>
        var simplemde_task = new SimpleMDE({
            spellChecker: false,
            element: document.getElementById("text")
        });
    </script>
@endsection

