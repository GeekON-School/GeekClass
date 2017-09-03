@extends('layouts.app')

@section('content')

    <div class="row" style="margin-top: 15px;">
        <div class="col-md-4">

            <div class="card">
                <img class="card-img-top"
                     src="{{url('/media/'.$user->image)}}"
                     alt="Card image cap">
                <div class="card-body">
                    <h4 class="card-title">{{$user->name}}</h4>

                    <p><strong>Дата рождения:</strong> {{$user->birthday->format('Y-m-d')}}<br>
                    <strong>Место учебы:</strong> {{$user->school}}<br>
                    <strong>Класс:</strong> {{$user->grade()}}</p>

                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50"
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p style="margin-top: 15px;">
                        <span style="font-size: 15px;" class="badge badge-pill badge-success"><i
                                    class="icon ion-ios-arrow-up"></i> Капитан</span><br><span
                                class="badge badge-pill badge-primary">Веб-разработка</span><span
                                class="badge badge-pill badge-primary">Фронтэнд</span>
                    </p>
                </div>
                <ul class="list-group list-group-flush">
                    @if ($user->telegram!='')
                        <li class="list-group-item"> <img src="https://png.icons8.com/telegram-app/win10/16"
                                                         title="Telegram App" width="16"
                                                         height="16"><strong> Telegram: </strong>
                            {{$user->telegram}}</li>
                    @endif
                    @if ($user->git!='')
                        <li class="list-group-item"> <img src="https://png.icons8.com/git/color/24" title="Git" width="16" height="16"><strong> Git: </strong>
                            {{$user->git}}</li>
                    @endif
                    @if ($user->vk!='')
                        <li class="list-group-item"> <img src="https://png.icons8.com/vkontakte/color/24"
                                                         title="VKontakte" width="16"
                                                         height="16">
                            <strong> VK: </strong>
                            {{$user->vk}}</li>
                    @endif
                    @if ($user->facebook!='')
                        <li class="list-group-item"> <img src="https://png.icons8.com/facebook/color/24" title="Facebook"
                                                         width="16"
                                                         height="16"><strong> Facebook: </strong>
                            {{$user->facebook}}</li>
                    @endif
                </ul>



            </div>

        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">О себе<a class="btn btn-sm btn-success float-right" href="{{'/insider/profile/'.$user->id.'/edit'}}">Редактировать</a></h4>
                    <p><strong>Технологические интересы:</strong> {{$user->interests}}</p>
                    <p><strong>Увлечения:</strong> {{$user->hobbies}}</p>
                </div>
            </div>
        </div>

    </div>
    <script>
        var simplemde_description = new SimpleMDE({
            spellChecker: false,
            element: document.getElementById("description")
        });
        var simplemde_theory = new SimpleMDE({spellChecker: false, element: document.getElementById("theory")});
    </script>
@endsection
