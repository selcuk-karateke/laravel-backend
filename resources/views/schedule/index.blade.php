@extends('layouts.app')

@section('content')
<p><a href='{{ url('/') }}'>Home</a></p><br/>
<p><a href='{{ url('/dbtest') }}'>DB Test</a></p>

@endsection

@section('projects')
    {{-- Title --}}
    <div class="schedule">
        <div><b>./.</b></div>
        <div><b>./.</b></div>
        <div><b>MO</b></div>
        <div><b>DI</b></div>
        <div><b>MI</b></div>
        <div><b>DO</b></div>
        <div><b>FR</b></div>
    </div>
    {{-- Title with Day Of Week --}}
    <div class="schedule">
        <div><b>Hour</b></div>
        <div><b>Name</b></div>
        @for($i = 0; $i < 5; $i++)
            <div>
                @if($date->isoformat('d') == 0)
                    {{ $date->isoformat('D') + $i + 1 }}
                @elseif($date->isoformat('d') == 1)
                    {{ $date->isoformat('D') + $i + 0 }}
                @elseif($date->isoformat('d') == 2)
                    {{ $date->isoformat('D') + $i - 1 }}
                @elseif($date->isoformat('d') == 3)
                    {{ $date->isoformat('D') + $i - 2 }}
                @elseif($date->isoformat('d') == 4)
                    {{ $date->isoformat('D') + $i - 3 }}
                @elseif($date->isoformat('d') == 5)
                    {{ $date->isoformat('D') + $i - 4 }}
                @elseif($date->isoformat('d') == 6)
                    {{ $date->isoformat('D') + $i + 2 }}
                @endif
            </div>
        @endfor
    </div>
    @for($i = 1; $i < 9; $i++)
    <div class="schedule">
        {{-- Hours --}}
        <div class="title flex-center m-b-md">
            {{$i}}
        </div>
        {{-- Managers --}}
        <div>
        @foreach($data['projects'] as $project)
                <div>
                    {{$project['manager']}}
                </div>
            @endforeach
        </div>
        {{-- Shortcuts --}}
        <div>
            @foreach($data['projects'] as $project)
                <div>
                    @foreach($data['projects'] as $p)
                        @if($project['manager'] == $p['manager'])
                            <a href='{{ url('#') }}'>{{$p['shortcut']}}</a>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
        <div>
            @foreach($data['projects'] as $project)
                <div>
                    @foreach($data['projects'] as $p)
                        @if($project['manager'] == $p['manager'])
                            <a href='{{ url('#') }}'>{{$p['shortcut']}}</a>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
        <div>
            @foreach($data['projects'] as $project)
                <div>
                    @foreach($data['projects'] as $p)
                        @if($project['manager'] == $p['manager'])
                            <a href='{{ url('#') }}'>{{$p['shortcut']}}</a>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
        <div>
            @foreach($data['projects'] as $project)
                <div>
                    @foreach($data['projects'] as $p)
                        @if($project['manager'] == $p['manager'])
                            <a href='{{ url('#') }}'>{{$p['shortcut']}}</a>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
        <div>
            @foreach($data['projects'] as $project)
                <div>
                    @foreach($data['projects'] as $p)
                        @if($project['manager'] == $p['manager'])
                            <a href='{{ url('#') }}'>{{$p['shortcut']}}</a>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    @endfor
@endsection
