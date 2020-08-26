@extends('layouts.app')

@section('title')
    <p class="title">{{ __('Add Task') }}</p>
@endsection

@section('aside')

@endsection
@section('section-1')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="sub-title">
        {{ __('Hi') }}, {{ Auth::user()->name }}!
    </div>

    <div class="links">
        <a href="{{ url('/dashboard') }}">Dashboard</a>
        <a href='{{ url('/projects') }}'>Projects</a>
        <a href='{{ url('/tasks') }}'>Tasks</a>
        <a href='{{ url('/') }}'>Main</a>
        <a href='{{ url('/users') }}'>Users</a>
    </div>
@endsection
@section('section-2')
    <form id="myForm">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" class="form-control" name="description" rows="4" cols="50"></textarea>
        </div>
        <div class="form-group">
            <label for="employee_id">Employee ID:</label>
            <input type="text" class="form-control" id="employee_id">
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <input type="text" class="form-control" id="status">
        </div>
        <div class="form-group">
            <label for="estimated_hours">Estimated Hour:</label>
            <input type="text" class="form-control" id="estimated_hours">
        </div>
        <div class="form-group">
            <label for="real_hours">Real Hours:</label>
            <input type="text" class="form-control" id="real_hours">
        </div>
        <div class="form-group">
            <label for="calendar_week">Calendar Week:</label>
            <input type="text" class="form-control" id="calendar_week">
        </div>
        <div class="form-group">
            <label for="task_end">Task End:</label>
            <input type="date" class="form-control" id="task_end">
        </div>
        <div class="form-group">
            <label for="real_end">Real End:</label>
            <input type="date" class="form-control" id="real_end">
        </div>
        <div class="form-group">
            <label for="charged">Charged:</label>
            <input type="text" class="form-control" id="charged">
        </div>
        <button class="btn btn-primary" id="ajaxSubmit">Submit</button>
    </form>
@endsection
