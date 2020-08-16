<tr>
    <th scope="row">{{$project->id}}</th>
    <td>
        <h2 style="margin-bottom: 0px">{{$project->name}}</h2>
        <br/>Estim. Hours:
        {{$project->estimated_hours}}
        <br/>Manager:
        {{$project->employee_id}}
    </td>
    <td>{{$project->shortcut}}</td>
    <td>{{$project->description}}</td>
    <td>{{$project->days}}<br/>
    @php
        use Carbon\Carbon;
        $start = Carbon::parse($project->start);
        $today = Carbon::now();
        $dead = Carbon::parse($project->dead);

        $diffStartEnd = $start->diffInHours($dead);
        $diffNowEnd = $today->diffInHours($dead);
    @endphp

    @if($start->greaterThanOrEqualTo($today))
            <br/>   {{ "Hold On" }}
    @endif

    @if($dead->lessThanOrEqualTo($today))
            <br/>{{ "Time Over" }}
    @endif
        <br/>{{ $diffStartEnd." / ".$diffNowEnd }}
    </td>
    <td>{{$project->start}}</td>
    <td>{{$project->dead}}</td>
    <td>
        E-Mail:<br/>
        {{$project->employee_id}}<br/>
        WWW:<br/>
        {{$project->employee_id}}
    </td>
    <td>
        <a class="btn btn-primary" href="{{ route('projects.show', $project->id) }}">Show</a> |
        <a class="btn btn-link p-0 m-0 align-baseline" href="{{ route('projects.edit', $project->id) }}">Edit</a><br/>
    </td>
</tr>
