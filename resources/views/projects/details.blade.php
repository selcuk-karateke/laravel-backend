
<div>{{$project['name']}}</div>
<div>{{$project['shortcut']}}</div>
<div>{{$project['manager']}}</div>

<div>{{$project['details']['start']}}</div>
<div>
@php
use Carbon\Carbon;
$start = Carbon::parse($project['details']['start']);
$today = Carbon::now();
$dead = Carbon::parse($project['details']['dead']);

$diffStartEnd = $start->diffInHours($dead);
$diffNowEnd = $today->diffInHours($dead);

@endphp
@if($start > $today)
    {{ "Hold On" }}
@elseif($dead <= $today)
    {{ "Time Over" }}
@else
    {{ $diffStartEnd." / ".$diffNowEnd }}
@endif

</div>
<div>{{$project['details']['dead']}}</div>
<div>{{$project['details']['mail']}}</div>
<div>{{$project['details']['link']}}</div>
