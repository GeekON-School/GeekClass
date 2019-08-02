@extends('layouts.full')

@section('title')
    GeekClass: курсы
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <h5 style="margin-top: 15px;">Открытые заочные курсы</h5>
            @if ($open_courses->count() != 0)
                <div class="card-deck">
                    @foreach($open_courses as $course)

                        <div class="card"
                             style="min-width: 280px; background-image: url({{$course->image}}); border-left: 3px solid #17a2b8;">
                            <div class="card-body"
                                 style="background-color: rgba(255,255,255,0.9);">
                                <h5 style="font-weight: 300;"
                                    class="card-title">{{$course->name}}</h5>
                                <p class="card-text"
                                   style="font-size: 0.8rem;">{{$course->description}}</p>
                                <a href="{{ url('/register?course_id='.$course->id) }}"
                                   class="btn btn-info btn-sm">Зарегистрироваться</a>

                                @if ($course->site != null)
                                    <a target="_blank" href="{{$course->site}}"
                                       style="margin-top: 6px; font-size: 0.8rem;"
                                       class="float-right">О курсе</a>
                                @endif


                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>Сейчас нет доступных открытых курсов.</p>@endif

            <h5 style="margin-top: 15px;">Очные курсы курсы</h5>
            @if ($private_courses->count() != 0)
                <div class="card-deck">
                    @foreach($private_courses as $course)

                        <div class="card"
                             style="min-width: 280px; background-image: url({{$course->image}});">
                            <div class="card-body"
                                 style="background-color: rgba(255,255,255,0.9);">
                                <h5 style="font-weight: 300;"
                                    class="card-title">{{$course->name}}</h5>
                                <p class="card-text"
                                   style="font-size: 0.8rem;">{{$course->description}}</p>

                                <p class="card-text text-muted">
                                    @if ($course->state != 'draft')
                                        Курс начался {{ $course->start_date->format('d.m.Y') }}.
                                    @else
                                        Курс начнется {{ $course->start_date->format('d.m.Y') }}.
                                    @endif
                                </p>

                                @if ($course->site != null)
                                    <a target="_blank" href="{{$course->site}}"
                                       style="margin-top: 6px; font-size: 0.8rem;"
                                       class="float-right">О курсе</a>
                                @endif


                            </div>
                            <div class="card-footer text-center" style="padding-left:0;">
                                <a href="https://goo.gl/forms/jMsLU855JBFaZRQE2" target="_blank"
                                   class="btn btn-info btn-sm">Оставить заявку</a>
                            </div>
                        </div>
                    @endforeach

                </div>
            @else
                <p>Сейчас нет доступных очных курсов.</p>
            @endif
        </div>

    </div>


@endsection
