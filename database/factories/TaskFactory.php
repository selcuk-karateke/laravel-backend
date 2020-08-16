<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Task::class, function (Faker $faker) {
    //
    return [
        'employee_id' => rand(1,10),
        'project_id' => rand(1,10),
        'calendar_week' => rand(0,52),
        'workonday' => date('Y-m-d H:i:s'),
    ];
});
