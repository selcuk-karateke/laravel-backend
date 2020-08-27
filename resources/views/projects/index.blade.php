@extends('layouts.app')
@section('title')
    <p class="title">{{ __('Projects') }}</p>
@endsection
@section('aside')
    <a href="{{ route('projects.create') }}"><i class="fas fa-plus fa-fw"></i> | Project</a>
@endsection

@section('section-1')
<div style="height: 15vh;">
    <div class="links">
        <a href="{{ url('/dashboard') }}">Dashboard</a>
        <a href='{{ url('/projects') }}'>Projects</a>
        <a href='{{ url('/tasks') }}'>Tasks</a>
        <a href='{{ url('/') }}'>Main</a>
        <a href='{{ url('/users') }}'>Users</a>
    </div>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="sub-title">
        {{ count($data) }} Projects found!
    </div>
</div>
@endsection
@section('section-2')
<div style="height: 10vh;">
    <form action="/projects" method="post">
        @csrf
        <div class="input-group">
            <select class="custom-select" id="inputMonth" name="inputMonth">
                <option selected>Choose Month...</option>
                <option value="1" {{isset($month) && $month == 1 ?'selected':''}}>January</option>
                <option value="2" {{isset($month) && $month == 2 ?'selected':''}}>February</option>
                <option value="3" {{isset($month) && $month == 3 ?'selected':''}}>March</option>
                <option value="4" {{isset($month) && $month == 4 ?'selected':''}}>April</option>
                <option value="5" {{isset($month) && $month == 5 ?'selected':''}}>May</option>
                <option value="6" {{isset($month) && $month == 6 ?'selected':''}}>June</option>
                <option value="7" {{isset($month) && $month == 7 ?'selected':''}}>July</option>
                <option value="8" {{isset($month) && $month == 8 ?'selected':''}}>August</option>
                <option value="9" {{isset($month) && $month == 9 ?'selected':''}}>September</option>
                <option value="10" {{isset($month) && $month == 10 ?'selected':''}}>October</option>
                <option value="11" {{isset($month) && $month == 11 ?'selected':''}}>November</option>
                <option value="12" {{isset($month) && $month == 12 ?'selected':''}}>December</option>
            </select>
            <div class="input-group-append">
                <button class="btn btn-secondary" type="submit" name="submitMonth">Go</button>
            </div>
        </div>
    </form>
    <form action="/projects" method="post">
        @csrf
        <div class="input-group">
            <div class="input-group-append">
                <button class="btn btn-secondary" type="submit" name="syncTable" value="1">Sync</button>
            </div>
        </div>
    </form>
</div>

<table>
    @foreach($shortcuts as $shortcut)
    <tr>
        <td>{{ $shortcut }}</td>
    </tr>
    @endforeach
</table>

@endsection

@section('section-3')

<div class="table-responsive">
    @if( count($data) )
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col" style="width:5%">#</th>
                <th scope="col">Name</th>
                <th scope="col">Shortcut</th>
                <th scope="col">Estim. Hours</th>
                {{--                <th scope="col">Estimated Hours</th>    4h --}}
                {{--                <th scope="col">Real Hours</th>         2h 50% Progress --}}
                {{--                <th scope="col">Remaining Hours</th>    4h - 2h = 2h--}}
                {{--                <th scope="col">Progress</th>           0 - 100% --}}
                {{--                <th scope="col">Status</th>             Kanban --}}
                <th scope="col">Days</th>
                <th scope="col">Start</th>
                <th scope="col">Dead</th>
                {{--                <th scope="col">Proj End</th> 18te--}}
                {{--                <th scope="col">Real End</th> 16te bonus - 19te kein bonus--}}
                <th scope="col">Details</th>
                {{--                <th scope="col">Charged</th> manuell budget 10000--}}
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)
                @include('projects.details', array('project'=>$project, 'employees'=>$employees))
            @endforeach
            </tbody>
        </table>
{{--        {!! $projects->render() !!}--}}
    @else
        <br/>
        <h1 class="flex-1">No Data</h1>
    @endif
</div>

@endsection
