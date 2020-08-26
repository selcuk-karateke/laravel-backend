<tr>
    <th scope="row">{{$project->id}}</th>
    <td>
        <h2 style="margin-bottom: 0px">{{$project->name}}</h2>
        <br/>Description:
        {{$project->description}}
        <br/>Manager:
        @foreach($project->employees as $employee)
            {{$employee->from_api}}
        @endforeach
    </td>
    <td>{{$project->shortcut}}</td>
    <td>{{$project->estimated_hours}}</td>
    <td>Total: {{$project->days}} Days<br/>
    @php
        use Carbon\Carbon;
        $start = Carbon::parse($project->start);
        $today = Carbon::now();
        $dead = Carbon::parse($project->dead);

        $diffStartEnd = $start->diffInHours($dead);
        $diffNowEnd = $today->diffInHours($dead)

    @endphp

        @if($start->isAfter($today))
            <i class="far fa-hand-paper fa-fw"></i> <span style="color: darkorange"><b>{{ "Hold On" }}</b></span><br/>
        @endif

        @if($dead->lessThanOrEqualTo($today))
            <i class="far fa-calendar-check fa-fw"></i> <span style="color: darkred"><b>{{ "Time Over" }}</b></span><br/>
        @endif

        @if($today->between($start, $dead))
            <br/>Total: {{ $diffStartEnd }} h
            <br/>Left: {{ $diffNowEnd }} h
        @endif
    </td>
    <td>{{$project->start}}</td>
    <td>{{$project->dead}}</td>
    <td>
        E-Mail:<br/>
{{--        {{$email}}<br/>--}}
        WWW:<br/>
{{--        {{$www}}--}}
    </td>
    <td>
        <a class="btn btn-primary" href="{{ route('projects.show', $project->id) }}">Show</a> |
        <a class="btn btn-link p-0 m-0 align-baseline" href="{{ route('projects.edit', $project->id) }}">Edit</a><br/>
    </td>
</tr>
