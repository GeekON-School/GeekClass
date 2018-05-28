@extends('layouts.app')

@section('content')
        <br>
        <h2 style="margin-top: -25px">Добавить событие</h2>
            <form method="POST">
                {{ csrf_field() }}
                <div class = "form-group required">
                    <label>Тип события</label>
                    <div class="radio">
                        <div><input type="radio" name="type" value="Внешнее" checked>Внешнее</div>
                        <div><input type="radio" name="type" value="Внутреннее">Внутреннее</div>
                    </div>
                </div>

                <div class = "form-group required">
                    <label>Название события</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class = "form-group required">
                    <label>Краткое описание события</label>
                    <input name="short_text" class="form-control" required>
                </div>

                <div class = "form-group required">
                    <label>Описание события</label>
                    <textarea name="text" class="form-control" required></textarea>
                </div>

                <div class = "form-group required">
                    <label>Дата проведения мероприятия</label>
                    <input type="date" name="date" class="form-control" required>
                </div>

                <div class = "form-group required">
                    <label>Место проведения мероприятия</label>
                    <input name="location" class="form-control" required>
                </div>

                <div class = "form-group">
                    <label>Ограничение на кол-во участников</label>
                    <input type="number" name="max_people" class="form-control" >
                </div>

                <div class = "form-group">
                    <label>Сайт мероприятия</label>
                    <input name="site" class="form-control" >
                </div>

                <div class = "form-group">
                    <label>Что должны знать участники</label>
                    <input name="skills" class="form-control" >
                </div>

                <div class="form-group row">
                    @foreach($tags as $tag)
                        @if($tag->id !=1)
                        <div class="col-md-3">
                             <div class="card" style="width: 100%; margin-bottom: 10px;">
                                 <div class="card-body">
                                     <div class="form-check " style="margin-left: 10px;">
                                         <input type="checkbox" name="tags[]" class="form-check-input" value="{{$tag->id}}" id="{{$tag->id}}">
                                         <label for="{{$tag->id}}" class="form-check-label">{{$tag->name}}</label>
                                     </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>

                    <input type="submit" value="Добавить" class = "btn btn-success">
            </form>
    <br>
@endsection