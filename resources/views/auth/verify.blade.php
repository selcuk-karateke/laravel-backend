@extends('layouts.app')
@section('title')
    <p class="title">{{ __('Verify') }}</p>
@endsection
@section('aside')

@endsection
@section('section-1')
    <div style="height: 80vh;">
        <div class="links">
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
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
            Register Page.
        </div>
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }},
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
            </form>
    </div>
@endsection
