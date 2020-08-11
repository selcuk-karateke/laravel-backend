
<div>{{$project['name']}}</div>
<div>{{$project['shortcut']}}</div>
<div>{{$project['manager']}}</div>

<div>{{$project['details']['start']}}</div>
<div>
<?php
use Carbon\Carbon;
$start = Carbon::parse($project['details']['start']);
$today = Carbon::now();
$dead = Carbon::parse($project['details']['dead']);

$diffStartEnd = $start->diffInHours($dead);
$diffNowEnd = $today->diffInHours($dead);

if($start > $today){
    echo "Hold On";
} elseif($dead <= $today){
    echo "Time Over";
} else {
    echo $diffStartEnd." / ".$diffNowEnd;
}
?>
</div>
<div>{{$project['details']['dead']}}</div>
<div>{{$project['details']['mail']}}</div>
<div>{{$project['details']['link']}}</div>
