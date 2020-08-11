@extends('layouts.app')


@section('content')
    <a href='{{ url('/schedule') }}'>Schedule</a>
@endsection

@section('projects')
    <div class="project">
        <div><b>Name</b></div>
        <div><b>Shortcut</b></div>
        <div><b>Manager</b></div>
        <div><b>Start</b></div>
        <div><b>Hours</b></div>
        <div><b>Dead</b></div>
        <div><b>Mail</b></div>
        <div><b>Link</b></div>
    </div>
    @foreach($data['projects'] as $project)
        <div class="project">
        @include('projects.details', array('project'=>$project))
        </div>
    @endforeach
@endsection
