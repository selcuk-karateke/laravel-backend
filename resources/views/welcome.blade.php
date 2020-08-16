@extends('layouts.app')
@section('title')
    <p class="title">{{ __('Main') }}</p>
@endsection
@section('aside')

@endsection

@section('content')
    <div class="content">
        <div class="flex-center-1 sub-title m-b-md">
            Nice To Meet U!
        </div>

        <div class="links">
            <a href="https://laravel.com/docs">Docs</a>
            <a href="https://laracasts.com">Laracasts</a>
            <a href="https://laravel-news.com">News</a>
            <a href="https://blog.laravel.com">Blog</a>
            <a href="https://nova.laravel.com">Nova</a>
            <a href="https://forge.laravel.com">Forge</a>
            <a href="https://vapor.laravel.com">Vapor</a>
            <a href="https://github.com/laravel/laravel">GitHub</a>
        </div>
    </div>
@endsection
