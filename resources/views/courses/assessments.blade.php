@extends('layouts.full')

@section('title')
    GeekClass: Добавление курса
@endsection

@section('content')
    <h2 style="margin: 20px;"><a class="back-link" href="{{url('/insider/courses/'.$course->id)}}"><i
                    class="icon ion-chevron-left"></i></a>&nbsp;Успеваемость по курсу "{{$course->name}}"</h2>
    <div class="assessment-block" style="background-color: #212529">
        <div class="table-wrapper">
            <table class="table table-inverse table-striped  table-sm">
                <thead class="thead-inverse">
                <tr>
                    <th style="border-bottom: none;"></th>
                    @foreach($course->steps as $step)
                        @if ($step->tasks->count()!=0)
                            <td colspan="{{$step->tasks->count()}}">{{$step->name}}</td>
                        @endif
                    @endforeach
                    <td class="bg-info"></td>
                </tr>
                </thead>
                <tbody>
                <tr class="bg-primary">
                    <th></th>
                    @php
                        $sum = 0;
                    @endphp
                    @foreach($course->steps as $step)

                        @foreach($step->tasks as $task)

                            <td>{{$task->name}} ({{$task->max_mark}})</td>
                            @php
                                $sum += $task->max_mark;
                            @endphp
                        @endforeach
                    @endforeach
                    <td class="bg-info">Сумма ({{$sum}})</td>
                </tr>
                @foreach($course->students as $student)
                    <tr>
                        <th scope="row">{{$student->name}}</th>
                        @php
                            $sum = 0;
                        @endphp
                        @foreach($course->steps as $step)

                            @foreach($step->tasks as $task)
                                @php

                                    $filtered = $student->submissions->filter(function ($value) use ($task) {
                                        return $value->task_id == $task->id;
                                    });
                                    $mark = $filtered->max('mark');
                                    $mark = $mark == null?0:$mark;
                                    $need_check = false;
                                    if ($filtered->count()!=0 && $filtered->last()->mark==null)
                                    {
                                        $need_check = true;
                                    }
                                    $sum += $mark;


                                @endphp
                                <td>
                                    <a href="{{url('/insider/tasks/'.$task->id.'/student/'.$student->id)}}">
                                        @if ($need_check)
                                            <span class="badge badge-warning">{{$mark}}</span>
                                        @else
                                            <span class="badge badge-light">{{$mark}}</span>
                                        @endif
                                    </a>
                                </td>
                            @endforeach

                        @endforeach
                        <td class="bg-info">{{$sum}}<br>&nbsp;</td>
                    </tr>
                @endforeach
                </tbody>


            </table>
        </div>
    </div>
@endsection