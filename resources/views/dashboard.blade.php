@extends('layouts.app')
@section('title')
    <p class="title">{{ __('Dashboard') }}</p>
@endsection
@section('aside')

@endsection
@section('section-1')
    <div style="height: 80vh;">
        <div class="links">
            <a href="{{ url('/dashboard') }}">Dashboard</a>
            <a href='{{ url('/projects') }}'>Projects</a>
            <a href='{{ url('/tasks') }}'>Tasks</a>
            <a href='{{ url('/') }}'>Main</a>
            <a href='{{ url('/users') }}'>Users</a>
        </div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="title">
            {{ __('Welcome') }}, {{ Auth::user()->name }}!
        </div>
        <div class="sub-title">
            This Is Your Dashboard.
        </div>

        <br/>
        <style>
            .card, .card-img-top {
                border-radius: 0;
                border-color:white;
            }
            .card-body {
                background-color:lightsteelblue;
            }
        </style>
            <div class="card-deck" style="width: 80%;">
        <div class="card" style="width: 18rem;">
            <div class="sub-title card-header text-right px-4">
                Projects <span class="badge rounded-0 badge-primary">{{$projects}}</span>
            </div>
{{--            <img class="card-img-top" src="images/projects.gif" alt="Card image cap">--}}
            <div class="card-body">
                <h5 class="card-title">Your Projects</h5>
                <p class="card-text">Projects: {{$projects}}</p>
{{--                @todo Projekte anzeigen--}}
                <a href="{{ url('/projects') }}" class="btn btn-primary">Go To Projects</a>
            </div>
            <div class="card-footer">
                <small class="text-muted">Last updated 3 mins ago</small>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="images/projects.gif" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Tasks</h5>
                <p class="card-text">Tasks: {{$tasks}}</p>
                <a href="{{ url('/tasks') }}" class="btn btn-primary">Go To Tasks</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="images/projects.gif" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Users</h5>
                <p class="card-text">Users: {{0}}</p>
                <a href="{{ url('/users') }}" class="btn btn-primary">Go To Users</a>
            </div>
        </div>
            </div>
    </div>
@endsection
