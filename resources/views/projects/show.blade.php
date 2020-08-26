@extends('layouts.app')

@section('title')
    <p class="title">{{ __('Show Project') }}</p>
@endsection

@section('aside')
{{--    @todo Add Task, User--}}

    <a href="#"><i class="far fa-calendar-plus fa-fw"></i></a>
| <a href="{{ route('tasks.create') }}">Add Task</a><br/>
    <a href="#"><i class="fas fa-app-store-ios-plus fa-fw"></i></a>
| <a href="#">Add From API</a><br/>
    <a href="#"><i class="fas fa-user-plus fa-fw"></i></a>
| <a href="#">Add Employee</a>
@endsection

@section('section-1')
    <div class="col-md-12">
        <h1>{{ strtoupper($data->name) }}</h1>
        <h5>{{ $data->shortcut }}, {{ $data->created_at }}</h5>
        <p>{{ $data->description }}</p>
        <p><b>Start: </b>{{ $data->start }} - <b>Dead: </b>{{ $data->dead }}</p>
        <p class="text-right">
            <a href='{{ url('/projects') }}'>Go To Projects</a>
            | <a class="btn btn-primary" href="{{ route('projects.edit', $data->id) }}">Edit</a>
        </p>
        <br/>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col" style="width:5%">#</th>
                <th scope="col">Task</th>
                <th scope="col" style="width:25%">Description</th>
                <th scope="col" style="width:25%">Status</th>
                <th scope="col">Hours</th>
                <th scope="col">End</th>
                <th scope="col">Charged</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <th scope="row">{{$task->id}}</th>
                    <td>
                        <h2 style="margin-bottom: 0px">{{$task->name}}</h2>
                        <br/>Week:
                        {{$task->calendar_week}}
                        <br/>Programmer:
                        {{$task->employee_id}}
                    </td>
                    <td>{{$task->description}}</td>
                    <td>{{$task->status}}</td>
                    <td>{{$task->estimated_hours}} / {{$task->real_hours}}</td>
                    <td>{{$task->task_end}} / {{$task->real_end}}</td>
                    <td>{{$task->charged}}</td>
                    <td>
                        <button class="btn btn-danger">Delete</button>
                        <button class="btn btn-light">Show</button>
                        <button class="btn btn-info">Edit</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
