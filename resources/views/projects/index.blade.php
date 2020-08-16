@extends('layouts.app')
@section('title')
    <p class="title">{{ __('Projects') }}</p>
@endsection
@section('aside')
    <a href="{{ route('projects.create') }}">Create Project</a>
@endsection

@section('content')
    <div class="table-responsive-xl">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col" style="width:5%">#</th>
                <th scope="col">Name</th>
                <th scope="col">Shortcut</th>
                <th scope="col" style="width:25%">Description</th>
{{--                <th scope="col">Total/Leftover</th>--}}
                <th scope="col">Days</th>
                <th scope="col">Start</th>
                <th scope="col">Dead</th>
                <th scope="col">Details</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $project)
                @include('projects.details', array('project'=>$project))
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
