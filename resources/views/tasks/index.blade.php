@php
    $date = Carbon\Carbon::now()
@endphp

@extends('layouts.app')

@section('title')
    <p class="title">{{ __('Tasks') }}</p>
@endsection

@section('aside')

@endsection

@section('section-1')
    asdf
@endsection

@section('section-2')
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col" style="width:5%"></th>
                <th scope="col"></th>
                <th scope="col">MO</th>
                <th scope="col">DI</th>
                <th scope="col">MI</th>
                <th scope="col">DO</th>
                <th scope="col">FR</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="col">Hours</th>
                <th scope="col">Employees</th>
                @for($i = 0; $i < 5; $i++)
                <th scope="col">
                    @if($date->isoformat('d') == 0)
                        {{ $date->addDays($i + 1)->isoFormat('DD.MM.') }}
                    @elseif($date->isoformat('d') == 1)
                        {{ $date->addDays($i + 0)->isoFormat('DD.MM.') }}
                    @elseif($date->isoformat('d') == 2)
                        {{ $date->addDays($i - 1)->isoFormat('DD.MM.') }}
                    @elseif($date->isoformat('d') == 3)
                        {{ $date->addDays($i - 2)->isoFormat('DD.MM.') }}
                    @elseif($date->isoformat('d') == 4)
                        {{ $date->addDays($i - 3)->isoFormat('DD.MM.') }}
                    @elseif($date->isoformat('d') == 5)
                        {{ $date->addDays($i - 4)->isoFormat('DD.MM.') }}
                    @elseif($date->isoformat('d') == 6)
                        {{ $date->addDays($i + 2)->isoFormat('DD.MM.') }}
                    @endif
                </th>
                @endfor
                <th>Action</th>
            </tr>
            @for($i = 1; $i < 9; $i++)
                @include('tasks.details', array('tasks'=>$tasks, 'employees'=>$employees))
            @endfor
            </tbody>
        </table>
    </div>
@endsection

@section('section-3')
    asdf
@endsection
