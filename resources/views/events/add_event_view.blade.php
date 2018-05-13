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
                    <input type="text" name="name" class="form-control" required value="{{old('name')}}">
                </div>
                <div class = "form-group required">
                    <label>Описание события</label>
                    <input type="text" name="text" class="form-control" value="{{old('job')}}">
                </div>

                <div class = "form-group required">
                    <label>Дата проведения мероприятия</label>
                    <input type="text" name="date" class="form-control" value="{{old('email')}}">
                </div>

                <div class = "form-group required">
                    <label>Место проведения мероприятия</label>
                    <input name="location" class="form-control" >{{old('comment')}}
                </div>

                <div class = "form-group">
                    <label>Краткое описание проекта</label>
                    <input name="short_text" class="form-control" >{{old('comment')}}
                </div>

                <div class = "form-group">
                    <label>Ограничение на кол-во участников</label>
                    <input name="max_people" class="form-control" >{{old('comment')}}
                </div>

                <div class = "form-group">
                    <label>Сайт мероприятия</label>
                    <input name="site" class="form-control" >{{old('comment')}}
                </div>

                <div class = "form-group">
                    <label>Что должны знать участники</label>
                    <input name="skills" class="form-control" >{{old('comment')}}
                </div>

                    <input type="submit" value="Добавить" class = "btn btn-success">
            </form>
    <br>
@endsection