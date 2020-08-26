@php
    // If JSON is available
    isset($json['fields']) ? $from_api = 1 : $from_api = 0;
    var_dump($from_api);
    var_dump(isset($json['fields']));
    $dead = isset($json['fields']['duedate'])? $json['fields']['duedate'] : "";
    //$descr_short = isset($json['fields']['summary'])? $json['fields']['summary'] : "";
    $estimated_hours = isset($json['fields']['aggregatetimeoriginalestimate'])? $json['fields']['aggregatetimeoriginalestimate'] : "";
    $actual_hours = isset($json['fields']['timetracking']['timeSpentSeconds'])? $json['fields']['timetracking']['timeSpentSeconds'] : "";
    $programmer = isset($json['fields']['assignee']['displayName'])? $json['fields']['assignee']['displayName'] : "";
    $tester = isset($json['fields']['customfield_11008']['displayName'])? $json['fields']['customfield_11008']['displayName']  : "";
    $status = isset($json['fields']['status']['name'])? $json['fields']['status']['name'] : "";
    $shortcut_ = isset($json['fields']['project']['key'])? $json['fields']['project']['key'] : "";
    $shortcut = isset($json['key'])? $json['key'] : "";
    $progress = isset($json['fields']['progress']['percent'])? $json['fields']['progress']['percent'] : "";
    $descr_short = isset($json['fields']['issuetype']['descr_short'])? $json['fields']['issuetype']['descr_short'] : "";
    $description = isset($json['fields']['issuetype']['description'])? $json['fields']['issuetype']['description'] : "";
    $name = isset($json['fields']['project']['name'])? $json['fields']['project']['name'] : "";
@endphp
@extends('layouts.app')

@section('title')
    <p class="title">{{ __('Create Project') }}</p>
@endsection

@section('aside')

@endsection
@section('section-1')
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
        Create A Project!
    </div>
@endsection
@section('section-2')
    <div class="row container-fluid">
        <div class="col-12 col-xl-6">
            <h2>From API</h2>
            <form action="/projects" method="post">
                @csrf
                <input type="hidden" value="1" name="from_api">
                <label for="inputShortcut">Shortcut</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Shortcut" id="inputShortcut" name="inputShortcut" aria-label="Shortcut" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" name="submitShortcut">Go</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <div class="collapse show" id="collapseAPI">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Dead</th>
                            <th>Short Description</th>
                            <th>Estimated Hours</th>
                            <th>Actual Hours</th>
                            <th>Programmer</th>
                            <th>Tester</th>
                            <th>Status</th>
                            <th>Shortcut</th>
                            <th>Progress</th>
                            <th>Description</th>
                            <th>Name</th>
                            @foreach($json as $l => $j)
                                <th scope="col" style="width:5%">{{$l}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $dead }}</td>
                            <td>{{ $descr_short }}</td>
                            <td>{{ $estimated_hours }}</td>
                            <td>{{ $actual_hours }}</td>
                            <td>{{ $programmer }}</td>
                            <td>{{ $tester }}</td>
                            <td>{{ $status }}</td>
                            <td>{{ $shortcut }}</td>
                            <td>{{ $progress }}</td>
                            <td>{{ $description }}</td>
                            <td>{{ $name }}</td>

                            <td>{{ isset($json['expand'])? print_r(explode( ',', $json['expand'])) : "" }}</td>
                            <td>{{ isset($json['id'])? $json['id'] : "" }}</td>
                            <td>{{ isset($json['self'])? $json['self'] : "" }}</td>
                            <td>{{ isset($json['key'])? $json['key'] : "" }}</td>
                            <td>{{-- isset($json['fields'])? print_r($json['fields']) : "" --}}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <h2>Direct</h2>
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
{{--            {!! Form::hidden('from_api', $from_api) !!}--}}
            <input type="hidden" value="{{$from_api}}" name="from_api">

            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', $name, ['id'=>'name', 'class'=>'form-control is-valid', 'placeholder'=>'Name']) !!}
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            {!! Form::label('description', 'Description') !!}
            {!! Form::textarea('description', $description, ['id'=>'description', 'class'=>'form-control is-valid', 'placeholder'=>'Description', 'rows'=>'3']) !!}

            {!! Form::label('descr_short', 'Descr. Short') !!}
            {!! Form::textarea('descr_short', $description, ['id'=>'descr_short', 'class'=>'form-control is-valid', 'placeholder'=>'Descr. Short', 'rows'=>'3']) !!}

{{--            {!! Form::label('employee_id', 'Employee ID') !!}--}}
{{--            {!! Form::text('employee_id', null, ['id'=>'employee_id', 'class'=>'form-control is-valid', 'placeholder'=>'Employee ID']) !!}--}}

            {!! Form::label('programmer', 'Programmer') !!}
            {!! Form::text('programmer', $programmer, ['id'=>'programmer', 'class'=>'form-control is-valid', 'placeholder'=>'Programmer']) !!}

            {!! Form::label('tester', 'Tester') !!}
            {!! Form::text('tester', $tester, ['id'=>'tester', 'class'=>'form-control is-valid', 'placeholder'=>'Tester']) !!}

            {!! Form::label('status', 'Status') !!}
            {!! Form::text('status', $status, ['id'=>'status', 'class'=>'form-control is-valid', 'placeholder'=>'Status']) !!}

            {!! Form::label('shortcut', 'Shortcut') !!}
            {!! Form::text('shortcut', $shortcut, ['id'=>'shortcut', 'class'=>'form-control is-valid', 'placeholder'=>'Shortcut']) !!}

            {!! Form::label('estimated_hours', 'Estimated Hours') !!}
            {!! Form::text('estimated_hours', $estimated_hours, ['id'=>'estimated_hours', 'class'=>'form-control is-valid', 'placeholder'=>'Estimated Hours']) !!}

            {!! Form::label('actual_hours', 'Actual Hours') !!}
            {!! Form::text('actual_hours', $actual_hours, ['id'=>'actual_hours', 'class'=>'form-control is-valid', 'placeholder'=>'Actual Hours']) !!}

            {!! Form::label('start', 'Start') !!}
            {!! Form::date('start', \Carbon\Carbon::now(), ['id'=>'start', 'class' => 'form-control is-valid']) !!}

            {!! Form::label('dead', 'Dead') !!}
            {!! Form::date('dead', $dead, ['id'=>'dead', 'class' => 'form-control is-valid']) !!}

            {!! Form::submit('Create', ['class'=>'btn btn-primary']) !!} | <a href="{{ URL::previous() }}">Go Back</a>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
