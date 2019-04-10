@extends('layouts.games', ['page' => 3])

@section('heading', 'Создать')

@section('content')

<form action="/insider/games" method="POST">
    @csrf
    
    <style scoped>
        h4
        {
            margin: 20px 0;
        }
    </style>
    @if ($errors->any())
        <div class="alert alert-danger">
            <div>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    <div style="margin-bottom: 5px;">
        <h4><label for="title">Название:</label></h4>
        <input class="form-control col" type="text" name="title" id="title" value="{{old('title')}}">
    </div>
    <div>
        <h4><label for="title">Описание:</label></h4>
        <textarea class="form-control" rows="10" type="text" name="description" id="text">{{old('description')}}</textarea>
    </div>

        <h4>Код:</h4>
    <div class="row" style="padding: 10px">
        <style scoped>
            .card
            {
                margin: 5px;
                padding: 0;
                overflow: hidden;
            }
            .meta
            {
                padding-right: 20px;
            }
            .ed > * > *
            {
                border: none;
            }
        </style>
        <div class="card col-md-6" style="min-height: 200px;">
            <div class="card-body">
            </div>
        </div>
        <div class="card col ed">
            <div class="card-body" style="margin:0; padding:0;">
                <textarea id="editor" name="code">{{old('code')?old('code'):\App\Game::template()}}</textarea>
            </div>
        </div>
    </div>
    <div class="row" style="padding: 10px;">
        
        <input type="submit" name="submit" id="submit" value="Запустить" class="col btn btn-primary">
    </div>
</form>

<div class="row">
    <div class="row-sm col">
        <h5 class="col-sm-1">engine.getMousePosition()</h5>
        <p class="col-sm-11 text-secondary">Возвращает положение мыши: x - положение по X, y - положение по Y</p>
        <p class="col-sm-11 text-secondary">Пример: <code>engine.getMousePosition().x</code> вернет положение по X относительно хоста </p>
    </div>
    <div class="row-sm col">
        <h5 class="col-sm-1">engine.mouseButtons</h5>
        <p class="col-sm-11 text-secondary">
            Возвращает текущий статус кнопок мыши (нажата, не нажата): [0] - левая кнопка, [1] - средняя кнопка (колесо), [2] - правая кнопка
        </p>
        <p class="col-sm-11 text-secondary">Пример: <code>engine.mouseButtons[0]</code> вернет нажата левая кнопка или нет</p>
    </div>
    <div class="row-sm col">
        <h5 class="col-sm-1">engine.keys</h5>
        <p class="col-sm-11 text-secondary">
            Возвращает текущий статус кнопок клавиатуры (нажата, не нажата), доступ через <code>engine.keys[key_code]</code> где <code>key_code</code> это код клавишы  
        </p>
        <p class="col-sm-11 text-secondary">Пример: <code>engine.keys['a']</code> вернет нажата ли клавиша <code>a</code></p>
    </div>
</div>
<div class="row-sm col" style="margin-bottom: 300px;">
    <h5 class="col-sm">Изучение JavaScript canvas</h5>
    <p class="col-sm text-secondary">
        Javascript canvas это технология которая используется для рисования в браузере 
    </p>
    <p class="col-sm text-secondary">Начните здесь: <a href="https://developer.mozilla.org/ru/docs/Web/API/Canvas_API">https://developer.mozilla.org/ru/docs/Web/API/Canvas_API</a> в этих примерах вместо <code>ctx</code> используется <code>context</code>, <br> для <code>canvas</code> используется <code>canvas</code></p>
</div>
<script src="{{asset('codemirror.js')}}"></script>
<script src="{{asset('javascript.js')}}"></script>

<script>
    var templ = '';
    var cm = CodeMirror.fromTextArea(document.getElementById("editor"), {
        lineNumbers: true,
        value: templ,
        mode:  "javascript"
    });
    cm.setOption("lineWrapping", true);
    var simplemde_text = new EasyMDE({
        spellChecker: false,
        autosave: true,
        element: document.getElementById("text")
    });

</script>
@endsection
