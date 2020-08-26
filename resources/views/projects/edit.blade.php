@extends('layouts.app')

@section('title')
    <p class="title">{{ __('Edit Project') }}</p>
@endsection

@section('aside')

    <br/>
    <br/>
    <br/>
    <a href="{{ route('projects.index') }}"
       onclick="event.preventDefault(); document.getElementById('destroy-form').submit();"> Delete Project |
        <i class="far fa-calendar-times fa-fw"></i>
    </a>
@endsection

@section('section-1')
    <div class="col-md-8">
        {!! Form::model($data, ['method'=>'PATCH', 'action'=>['ProjectsController@update',$data->id]]) !!}

            @csrf

            <div class="form-group row">
                {!! Form::label('name', 'Name', ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                <div class="col-md-6">
                    {!! Form::text('name', null, ['id'=>'name', 'class'=>'form-control', 'placeholder'=>'Name']) !!}
                </div>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group row">
                {!! Form::label('shortcut', 'Shortcut', ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                <div class="col-md-6">
                    {!! Form::text('shortcut', null, ['id'=>'shortcut', 'class'=>'form-control', 'placeholder'=>'Shortcut']) !!}
                </div>
                @error('shortcut')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group row">
                {!! Form::label('description', 'Description', ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                <div class="col-md-6">
                    {!! Form::textarea('description', null, ['id'=>'description', 'class'=>'form-control', 'placeholder'=>'Description', 'rows'=>'3']) !!}
                </div>
                @error('description')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>
            <div class="form-group row">
                {!! Form::label('', 'Total/Leftover', ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                <div class="col-md-6">
                    {!! Form::text('', null, ['id'=>'', 'class'=>'form-control', 'placeholder'=>'Total/Leftover', 'readonly']) !!}
                </div>
                @error('')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>
            <div class="form-group row">
                {!! Form::label('start', 'Start', ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                <div class="col-md-6">
                    {!! Form::date('start', null, ['id'=>'start', 'class'=>'form-control', 'placeholder'=>'Start']) !!}
                </div>
                @error('start')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>
            <div class="form-group row">
                {!! Form::label('dead', 'Dead', ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                <div class="col-md-6">
                    {!! Form::date('dead', null, ['id'=>'dead', 'class'=>'form-control', 'placeholder'=>'Dead']) !!}
                </div>
                @error('dead')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4 text-right">
                    <a href="{{ route('projects.index') }}"
                       onclick="event.preventDefault(); document.getElementById('destroy-form').submit();"
                       class="text-danger"> Delete
                    </a>
                    | <a href="{{ URL::previous() }}">Go Back</a>
                    | {!! Form::submit('Update', ['class'=>'btn btn-primary']) !!}
                </div>
            </div>
        {!! Form::close() !!}

        {!! Form::open(['id'=>'destroy-form', 'style'=>'display:none', 'method'=>'DELETE', 'action'=>['ProjectsController@destroy', $data->id]]) !!}
            @csrf
            {{--    {!! Form::submit('Delete', ['class'=>'btn btn-danger']) !!}--}}
        {!! Form::close() !!}
    </div>
@endsection
