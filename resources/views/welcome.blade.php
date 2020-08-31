@extends('layouts.app')
@section('title')
    <p class="title">{{ __('Main') }}</p>
@endsection
@section('aside')

@endsection

@section('section-1')
    <div style="height: 80vh;">
        <div class="links">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                    <a href='{{ url('/projects') }}'>Projects</a>
                    <a href='{{ url('/tasks') }}'>Tasks</a>
                    <a href='{{ url('/users') }}'>Users</a>
                @else
                    <a href="{{ route('login') }}">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            @endif
        </div>
        <div class="title">
            @if (Route::has('login'))
                @auth
                    {{ __('Hi') }}, {{ Auth::user()->name }}!
                @else
                    {{ __('Welcome') }}, Stranger!
                @endauth
            @endif
        </div>
        <div class="sub-title">
            Main Page.
        </div>
        <br/>
    </div>
@endsection
