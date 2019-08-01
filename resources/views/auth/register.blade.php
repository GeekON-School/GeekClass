@extends('layouts.full')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-8">
                            <h4>Регистрация</h4>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-success btn-sm float-right">Регистрация!</button>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">


                                    <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                        <label for="image">Аватар</label>

                                        <input id="image" type="file" class="form-control" name="image"/>

                                        @if ($errors->has('image'))
                                            <span class="help-block error-block"><strong>{{ $errors->first('image') }}</strong></span>
                                        @endif
                                    </div>
                                    <h4>Контакты</h4>
                                    <span class="help-block text-muted">Эти данные увидят только другие студенты школы. <strong>Они не видны из интернета.</strong></span>

                                    <div class="form-group">
                                        <label for='vk'>VK</label>

                                        <input id='vk' type="text" class="form-control" name='vk' value="{{old('vk')}}">
                                        @if ($errors->has('vk'))
                                            <span class="help-block error-block">
                                        <strong>{{ $errors->first('vk') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for='telegram'>Telegram</label>
                                        <input id='telegram' type="text" class="form-control" name='telegram'
                                               value="{{old('telegram')}}">

                                        @if ($errors->has('telegram'))
                                            <span class="help-block error-block">
                                        <strong>{{ $errors->first('telegram') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for='git'>Git</label>

                                        <input id='git' type="text" class="form-control" name='git'
                                               value="{{old('git')}}">
                                        @if ($errors->has('git'))
                                            <span class="help-block error-block">
                                        <strong>{{ $errors->first('git') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for='facebook'>Facebook</label>

                                        <input id='facebook' type="text" class="form-control" name='facebook'
                                               value="{{old('facebook')}}">
                                        @if ($errors->has('facebook'))
                                            <span class="help-block error-block">
                                        <strong>{{ $errors->first('facebook') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        {!! \NoCaptcha::display() !!}
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Инвайт</h4>
                                    <div class="form-group{{ $errors->has('invite') ? ' has-error' : '' }}">
                                        <label for="invite" class="control-label">Инвайт</label>


                                        <input id="invite" type="text" class="form-control" name="invite"
                                               value="{{ old('invite') }}" required>

                                        <span class="help-block text-muted">Инвайт на курс - код, который вы получили от преподавателя.</span>

                                        @if ($errors->has('invite'))
                                            <span class="help-block error-block"><strong>{{ $errors->first('invite') }}</strong></span>
                                        @endif

                                    </div>
                                    <h4>Аккаунт</h4>
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="control-label">E-Mail</label>


                                        <input id="email" type="email" class="form-control" name="email"
                                               value="{{ old('email') }}" required>

                                        <span class="help-block text-muted">Ваш действующий Email адрес, он будет вашим логином.</span>

                                        @if ($errors->has('email'))
                                            <span class="help-block error-block"><strong>{{ $errors->first('email') }}</strong></span>
                                        @endif

                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="control-label">Пароль</label>


                                        <input id="password" type="password" class="form-control" name="password"
                                               required>

                                        @if ($errors->has('password'))
                                            <span class="help-block error-block"><strong>{{ $errors->first('password') }}</strong></span>
                                        @endif

                                    </div>

                                    <div class="form-group">
                                        <label for="password-confirm" class="control-label">Повторите
                                            пароль</label>


                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required>

                                    </div>
                                    <h4>Профиль</h4>
                                    <div class="form-group">
                                        <label for='name'>Имя</label>

                                        <input id='name' type="text" class="form-control" name='name'
                                               value="{{old('name')}}"
                                               required>

                                        <span class="help-block text-muted">Ваше имя и фамилия.</span>

                                        @if ($errors->has('name'))
                                            <span class="help-block error-block"><strong>{{ $errors->first('name') }}</strong></span>
                                        @endif
                                    </div>


                                    <div class="form-group">
                                        <label for='birthday'>Дата рождения</label>

                                        <input id='birthday' type="text" class="form-control date" name='birthday'
                                               value="{{old('birthday')}}" required>
                                        <span class="help-block text-muted"><strong>Это обязательное поле.</strong></span>

                                        @if ($errors->has('birthday'))
                                            <span class="help-block error-block">
                                        <strong>{{ $errors->first('birthday') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for='school'>Место учебы</label>

                                        <input id='school' type="text" class="form-control" name='school'
                                               value="{{old('school')}}"
                                               required>

                                        <span class="help-block text-muted">Например, "Гимназия 1576". <strong>Это обязательное поле.</strong></span>


                                        @if ($errors->has('school'))
                                            <span class="help-block error-block">
                                        <strong>{{ $errors->first('school') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for='grade'>Класс</label>


                                        <input id='grade' type="text" class="form-control" name='grade'
                                               value="{{old('grade')}}"
                                               required>
                                        <span class="help-block text-muted">Ваш текущий класс, если сейчас лето, то класс в который вы переходите. <strong>Это обязательное поле.</strong></span>

                                        @if ($errors->has('grade'))
                                            <span class="help-block error-block">
                                        <strong>{{ $errors->first('grade') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <h4>О себе</h4>
                                    <div class="form-group">
                                        <label for='interests'>Технические интересы</label>
                                        <textarea id="interests" class="form-control"
                                                  name="interests">{{old('interests')}}</textarea>
                                        <span class="help-block text-muted">Все направления, предметы и технологии, которые вам могут быть интересны. Например, "Нейронные сети и блокчейн, разработка мобильных приложений на React Native". <strong>Это обязательное поле.</strong></span>

                                        @if ($errors->has('interests'))
                                            <span class="help-block error-block"><strong>{{ $errors->first('interests') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for='hobbies'>Увлечения</label>

                                        <textarea id="hobbies" class="form-control"
                                                  name="hobbies">{{old('hobbies')}}</textarea>
                                        <span class="help-block text-muted">Все, чем вы интересуетесь помимо учебы и работы. Например, "катание на лошадях и игра на гитаре". <strong>Это обязательное поле.</strong></span>

                                        @if ($errors->has('hobbies'))
                                            <span class="help-block error-block">
                                        <strong>{{ $errors->first('hobbies') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
