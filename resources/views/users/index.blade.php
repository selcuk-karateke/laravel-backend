@extends('layouts.app')
@section('title')
    <p class="title">{{ __('Users') }}</p>
@endsection
@section('aside')
    <a href="{{ route('users.create') }}">Add User</a> |
    <a href="{{ route('users.create') }}"><i class="fas fa-user-plus fa-fw"></i></a>
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

    <div class="sub-title">
        {{ __('Hi') }}, {{ Auth::user()->name }}!
    </div>
</div>
@endsection
@section('section-2')
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col" style="width:5%">#</th>
                <th scope="col">Name</th>
                <th scope="col">E-Mail</th>
                <th scope="col">Roles</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $user)
                @include('users.details', array('project'=>$user))
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('section-3')
    asdf
@endsection
