<tr>
    <th scope="row" class="sub-title">{{$i}}</th>
    <td>
        @foreach($employees as $employee)
        <div>
            {{$employee['surename']}}, {{$employee['forename']}}
        </div>
        @endforeach
    </td>
    <td>{{'shortcut'}}</td>
    <td>{{'shortcut'}}</td>
    <td>{{'shortcut'}}</td>
    <td>{{'shortcut'}}</td>
    <td>{{'shortcut'}}</td>
    <td>
        <a class="btn btn-primary" href="{{ route('projects.show', 'id') }}">Show</a> |
        <a class="btn btn-link p-0 m-0 align-baseline" href="{{ route('projects.edit', 'id') }}">Edit</a><br/>
    </td>
</tr>


{{--         Shortcuts--}}
{{--        <div>--}}
{{--            @foreach($data['projects'] as $project)--}}
{{--                <div>--}}
{{--                    @foreach($data['projects'] as $p)--}}
{{--                        @if($project['manager'] == $p['manager'])--}}
{{--                            <a href='{{ url('#') }}'>{{$p['shortcut']}}</a>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            @foreach($data['projects'] as $project)--}}
{{--                <div>--}}
{{--                    @foreach($data['projects'] as $p)--}}
{{--                        @if($project['manager'] == $p['manager'])--}}
{{--                            <a href='{{ url('#') }}'>{{$p['shortcut']}}</a>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            @foreach($data['projects'] as $project)--}}
{{--                <div>--}}
{{--                    @foreach($data['projects'] as $p)--}}
{{--                        @if($project['manager'] == $p['manager'])--}}
{{--                            <a href='{{ url('#') }}'>{{$p['shortcut']}}</a>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            @foreach($data['projects'] as $project)--}}
{{--                <div>--}}
{{--                    @foreach($data['projects'] as $p)--}}
{{--                        @if($project['manager'] == $p['manager'])--}}
{{--                            <a href='{{ url('#') }}'>{{$p['shortcut']}}</a>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            @foreach($data['projects'] as $project)--}}
{{--                <div>--}}
{{--                    @foreach($data['projects'] as $p)--}}
{{--                        @if($project['manager'] == $p['manager'])--}}
{{--                            <a href='{{ url('#') }}'>{{$p['shortcut']}}</a>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--    </div>--}}
