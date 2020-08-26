@extends('layouts.app')

@section('title')
    <p class="title">{{ __('Add User') }}</p>
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
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::open(['method'=>'POST', 'action'=>'UsersController@store', 'files'=>true]) !!}

    @csrf

    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class'=>'form-control is-valid', 'placeholder'=>'Name']) !!}
    @error('name') <div class="alert alert-danger">{{ $message }}</div> @enderror

    {{ Form::label('user_id', 'Employee')}}
    @php
        $q = $data->pluck('forename')->toArray();
        array_unshift($q, "Select Employee")
    @endphp
    {!! Form::select('user_id', $q, $data->pluck('id'), ['class' => 'form-control']) !!}

    {!! Form::label('email', 'E-Mail') !!}
    {!! Form::text('email', null, ['class'=>'form-control is-valid', 'placeholder'=>'E-Mail']) !!}
    @error('email') <div class="alert alert-danger">{{ $message }}</div> @enderror

    {!! Form::label('password', 'Password') !!}
    {!! Form::password('password', ['class'=>'form-control']) !!}
    @error('password') <div class="alert alert-danger">{{ $message }}</div> @enderror

    {!! Form::label('password-confirm', 'Confirm Password') !!}
    {!! Form::password('password-confirm', ['class'=>'form-control', 'name'=>'password_confirmation', 'required autocomplete'=>'new-password']) !!}

    {!! Form::submit('Create', ['class'=>'btn btn-primary']) !!} | <a href="{{ URL::previous() }}">Go Back</a>

    {!! Form::close() !!}
@endsection
