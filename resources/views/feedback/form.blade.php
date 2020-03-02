@extends('layouts.empty')

@section('head')
    <script>
        function toggleBlock(id, force) {
            var block = document.getElementById(id);
            if (force == undefined) {
                if (block.style.display == "none") {
                    block.style.display = "block";
                } else {
                    block.style.display = "none";
                }
            } else {
                block.style.display = "block";
            }

        }
    </script>
    <style>

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 0px;
            background: white;
            padding-bottom: 20px;
        }

        .form-check-input {
            margin-left: 0px;
        }
    </style>
@endsection

@section('content')
    <img style="height: 64px;" src="{{ url('images/icons/icons8-idea-64.png') }}">&nbsp;
    <h2 class="h3 mb-3 font-weight-normal">Обратная связь!</h2>

    @if (count($queries))

        <p>Заполняя форму ниже, вы помогаете нам стать лучше! А еще мы пришлем небольшой бонус...</p>

        <form method="post">
            {{ csrf_field() }}

            @foreach ($queries as $query)

                <div class="card">
                    <div class="card-body">
                        <h5>{{ $query->course->name }}<br><small>@if (count($query->course->teachers)){{ $query->course->teachers[0]->name }}, @endif{{ $query->created_at->format('d.m.Y') }}</small>
                        </h5>

                        <div class="form-check">
                            <input style="margin-left: 0px;" class="form-check-input" name="{{ $query->id }}_missed" type="checkbox" onclick="toggleBlock('{{ $query->id }}_block')" value="yes">
                            <label class="form-check-label">
                                Меня не было...
                            </label>
                        </div>

                        <div id="{{ $query->id }}_block">

                            <p><strong>Как прошло занятие?</strong></p>

                            <div class="form-group">

                                <div class="form-check form-check-inline">
                                    <span><input class="form-check-input" type="radio" name="{{ $query->id }}_mark" value="5"><label class="form-check-label"
                                                                                                                                     style="font-weight: bold; color: #1c7430;">5</label></span>
                                </div>
                                <div class="form-check form-check-inline">
                                    <span><input class="form-check-input" type="radio" name="{{ $query->id }}_mark" value="4" checked><label class="form-check-label">4</label></span>
                                </div>
                                <div class="form-check form-check-inline">
                                    <span><input class="form-check-input" type="radio" name="{{ $query->id }}_mark" value="3"><label class="form-check-label">3</label></span>
                                </div>
                                <div class="form-check form-check-inline">
                                    <span><input class="form-check-input" onclick="toggleBlock('{{ $query->id }}_contact', true)" type="radio" name="{{ $query->id }}_mark" value="2"><label
                                                class="form-check-label"
                                                style="font-weight: bold; color: darkred;">2</label></span>
                                </div>
                                <div class="form-check form-check-inline">
                                    <span><input class="form-check-input" onclick="toggleBlock('{{ $query->id }}_contact', true)" type="radio" name="{{ $query->id }}_mark" value="1"><label
                                                class="form-check-label"
                                                style="font-weight: bold; color: red;">1</label></span>
                                </div>


                                @if ($errors->has($query->id.'_mark'))
                                    <span class="help-block error-block">
                                            <strong>{{ $errors->first($query->id.'_mark') }}</strong>
                                        </span>
                                @endif

                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" name="{{ $query->id }}_not_late" type="checkbox" value="yes" style="margin-left: 0px;" checked>
                                    <label class="form-check-label">
                                        Преподаватель пришел на занятие во-время.
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="{{ $query->id }}_ready" type="checkbox" value="yes" style="margin-left: 0px;" checked>
                                    <label class="form-check-label">
                                        Занятие было структурировано и длилось не меньше 90 мин.
                                    </label>
                                </div>
                                <div style="display: none" id="{{ $query->id }}_contact">
                                    <div class="form-check">
                                        <input class="form-check-input" name="{{ $query->id }}_need_contact" type="checkbox" style="margin-left: 0px;"
                                               value="yes" @if (old($query->id.'_need_contact')) checked @endif>
                                        <label class="form-check-label">
                                            <span style="color: red;">Свяжитесь со мной!</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            @endforeach
            <button style="margin-top: 10px;" class="btn btn-lg btn-primary btn-block" type="submit">Готово</button>
        </form>
    @else
        <strong>Ссылка уже использована или еще не создана.</strong>
    @endif
@endsection
