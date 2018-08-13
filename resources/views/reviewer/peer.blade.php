@extends('layouts.fluid')

@section('title')
    GeekClass: "{{$task->name}}" - "Peer review"
@endsection

@section('tabs')

@endsection

@section('content')
    <div class="row">
        <table class="table">
            <tr>
                <th>id</th>
                <th>Имя</th>
                <th>Reviewer 1</th>
                <th>Reviewer 2</th>
                <th>Решение</th>
            </tr>
            @foreach($students as $id => $student)
                <tr>
                    <td>{{$id}}</td>
                    <td>{{$student->name}}</td>
                    <td>{{$student->reviewer1->name}}</td>
                    <td>{{$student->reviewer2->name}}</td>
                    <td>{{$student->solution}}</td>
                </tr>
            @endforeach
        </table>
    </div>


@endsection
