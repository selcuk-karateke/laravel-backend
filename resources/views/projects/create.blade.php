@extends('layouts.app')

@section('title')
    <p class="title">{{ __('Create Project') }}</p>
@endsection

@section('aside')

@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    {!! Form::open(['method'=>'POST', 'action'=>'ProjectsController@store', 'files'=>true]) !!}

        @csrf

        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['class'=>'form-control is-valid', 'placeholder'=>'Name']) !!}
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        {!! Form::label('description', 'Description') !!}
        {!! Form::textarea('description', null, ['class'=>'form-control is-valid', 'placeholder'=>'Description', 'rows'=>'3']) !!}

        {!! Form::label('employee', 'Employee') !!}
        {!! Form::text('employee', null, ['class'=>'form-control is-valid', 'value'=>'1', 'placeholder'=>'Employee']) !!}

        {!! Form::label('shortcut', 'Shortcut') !!}
        {!! Form::text('shortcut', null, ['class'=>'form-control is-valid', 'placeholder'=>'Shortcut']) !!}

        {!! Form::label('estimated_hours', 'Estimated Hours') !!}
        {!! Form::text('estimated_hours', null, ['class'=>'form-control is-valid', 'placeholder'=>'Estimated Hours']) !!}

        {!! Form::label('start', 'Start') !!}
        {!! Form::date('start', \Carbon\Carbon::now(), ['class' => 'form-control is-valid']) !!}

        {!! Form::label('dead', 'Dead') !!}
        {!! Form::date('dead', \Carbon\Carbon::now(), ['class' => 'form-control is-valid']) !!}

        {!! Form::submit('Create', ['class'=>'btn btn-primary']) !!} | <a href="{{ URL::previous() }}">Go Back</a>

    {!! Form::close() !!}
@endsection
