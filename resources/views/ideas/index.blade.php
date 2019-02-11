@extends('layouts.app')

@section('content')
    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <h2>Идеи</h2>
        </div>
        <div class="col">
            <ul class="nav nav-pills float-right" id="ideasTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active" role="tab"
                       aria-controls="active" aria-selected="true">Каталог</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="draft-tab" data-toggle="tab" href="#draft" role="tab"
                       aria-controls="draft" aria-selected="false">Ожидают утверждения</a>
                </li>
                <li class="nav-item" style="margin-left: 5px;">
                    <a class="btn btn-success btn-sm nav-link" href="{{url('/insider/ideas/create/')}}"><i
                                class="icon ion-plus-round"></i>&nbsp;Добавить</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab-content" id="ideas" style="margin-top: 15px;">
        <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active">
            <p style="margin-top: 10px;">В процессе изучения очень важно найти для себя интересные задачи. В этом
                разделе мы собираем идеи для проектов разной сложности, которые можно реализовать в процессе обучения:
                просто для развлечения или применять в повседневной жизни.</p>
            <p>Если у вас своя идея, которую вы хотели бы реализовать или предложить другим участникам - смело нажимайте
                кнопку <strong>"Добавить"</strong>! Как только ваша идея пройдет проверкуб она появится в этом списке, а
                вы получите за нее 5 GC.</p>
            <div class="row">
                <div class="col-12">
                    <div class="card-columns" style="-webkit-column-count:2;-moz-column-count:2;column-count:2;">
                        @foreach($approved_ideas as $letter => $list)
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{$letter}} </h5>
                                    <ul>

                                        @foreach($list as $idea)
                                            <li><a href="{{url('/insider/ideas/'.$idea->id)}}">{{$idea->name}}</a>&nbsp;<img
                                                        style="height: 25px;"
                                                        src="https://img.icons8.com/color/48/000000/idea-sharing.png">
                                                @if($idea->author->role=='student') &nbsp;<img style="height: 25px;"
                                                                                               src="https://img.icons8.com/color/48/000000/teamwork.png"
                                                                                               title="Идея сообщества"> @endif
                                                <br>
                                                <span class=" text-muted">{{$idea->short_description}}</span></li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="draft" role="tabpanel" aria-labelledby="draft">
            <p>Здесь вы видите предложенные вами идеи, которые пока не прошли проверку. Если идею долго не проверяют,
                напомните о ней вашему преподавателю.</p>
            <div class="row">
                <div class="col-12">
                    @if ($draft_ideas->count() == 0)
                        <div class="jumbotron">
                            <h1 class="display-4">Настало время для творчества!</h1>
                            <p class="lead" style="margin-top: 15px;">У тебя наверняка есть идея, которую тебе хотелось
                                бы
                                реализовать (или ты уже сделал в прошлом году и это было круто)? Опиши ее! Тогда твои
                                коллеги
                                тоже смогут разделить радость ее реализации.</p>
                            <a class="btn btn-primary btn-lg" style="margin-top: 15px;"
                               href="{{url('/insider/ideas/create/')}}"
                               role="button">Предложить идею!</a>
                        </div>
                    @endif

                    <div class="card-columns" style="-webkit-column-count:2;-moz-column-count:2;column-count:2;">
                        @foreach($draft_ideas as $letter => $list)

                            <div class="card" style="width: 50%;">
                                <div class="card-body">
                                    <h5 class="card-title">{{$letter}} </h5>
                                    <ul>

                                        @foreach($list as $idea)
                                            <li><a href="{{url('/insider/ideas/'.$idea->id)}}">{{$idea->name}}</a>&nbsp;<img
                                                        style="height: 25px;"
                                                        src="https://img.icons8.com/color/48/000000/idea-sharing.png">
                                                @if($idea->author->role=='student') &nbsp;<img style="height: 25px;"
                                                                                               src="https://img.icons8.com/color/48/000000/teamwork.png"
                                                                                               title="Идея сообщества"> @endif
                                                <br>
                                                <span class=" text-muted">{{$idea->short_description}}</span></li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>


                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
