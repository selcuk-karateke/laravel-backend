@extends('layouts.app')

@section('title')
    <p class="title">{{ __('Show Project') }}</p>
@endsection

@section('aside')

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3>{{ strtoupper($data->name) }}</h3>
                <h5>{{ $data->shortcut }}, {{ $data->created_at }}</h5>
                <p>{{ $data->description }}</p>
                <p><b>Start: </b>{{ $data->start }}</p>
                <p><b>Dead: </b>{{ $data->dead }}</p>
                <p>
                    <a class="btn btn-primary" href="{{ route('projects.edit', $data->id) }}">Edit</a>
                |
                    <a href="{{ URL::previous() }}">Go Back</a>
                </p>
            </div>
        </div>
    </div>
@endsection
