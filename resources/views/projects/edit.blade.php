@extends('layouts.app')

@section('title')
    <p class="title">{{ __('Edit Project') }}</p>
@endsection

@section('aside')

@endsection

@section('content')
    {!! Form::model($data, ['method'=>'PATCH', 'action'=>['ProjectsController@update',$data->id]]) !!}

        @csrf

        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Name']) !!}

        {!! Form::label('shortcut', 'Shortcut') !!}
        {!! Form::text('shortcut', null, ['class'=>'form-control', 'placeholder'=>'Shortcut']) !!}

        {!! Form::label('description', 'Description') !!}
        {!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder'=>'Description', 'rows'=>'3']) !!}

        {!! Form::label('', 'Total/Leftover') !!}
        {!! Form::text('', null, ['class'=>'form-control', 'placeholder'=>'Total/Leftover', 'readonly']) !!}

        {!! Form::label('start', 'Start') !!}
        {!! Form::date('start', null, ['class'=>'form-control', 'placeholder'=>'Start']) !!}

        {!! Form::label('dead', 'Dead') !!}
        {!! Form::date('dead', null, ['class'=>'form-control', 'placeholder'=>'Dead']) !!}

        {!! Form::submit('Update', ['class'=>'btn btn-primary']) !!} | <a href="{{ URL::previous() }}">Go Back</a>

    {!! Form::close() !!}
@endsection
