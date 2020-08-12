@extends('layouts.app')

@section('content')
    <p><a href='{{ url('/schedule') }}'>Schedule</a></p><br/>
    <p><a href='{{ url('/') }}'>Home</a></p>
@endsection

@section('projects')
    <?php var_dump($results); ?>
@endsection
