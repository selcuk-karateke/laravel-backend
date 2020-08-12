@extends('layouts.app')

@todo

@section('content')
    <p><a href='{{ url('/schedule') }}'>Schedule</a></p><br/>
    <p><a href='{{ url('/dbtest') }}'>DB Test</a></p>
@endsection
<?php
/*
@todo
INSERT INTO `tasks`(`id`,`name`,`shortcut`,`calendar_week`,`employee_id`,`estimated_hours`,`workonday`,`dead`,`created_at`,`updated_at`)
VALUES(NULL,'Online Shop','ABC','33','1','40','2020-08-13 00:00:00','2020-08-14',NULL,NULL);


INSERT INTO laravel_bta.employees(`id`,`forename`,`surename`,`role_id`,`created_at`,`updated_at`)
SELECT `id`,`forename`,`surename`,`role_id`,`created_at`,`updated_at`
FROM laravel_old.employees

INSERT INTO laravel_bta.roles(`id`,`name`,`created_at`,`updated_at`)
SELECT `id`,`name`,`created_at`,`updated_at`
FROM laravel_old.roles
*/
?>

@section('projects')
<div class="project">
<div><b>Name</b></div>
<div><b>Shortcut</b></div>
<div><b>Manager</b></div>
<div><b>Start</b></div>
<div><b>Hours</b></div>
<div><b>Dead</b></div>
<div><b>Mail</b></div>
<div><b>Link</b></div>
</div>
@foreach($data['projects'] as $project)
<div class="project">
@include('projects.details', array('project'=>$project))
</div>
@endforeach
@endsection
