<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Task::class, function (Faker $faker) {
//        'description'=>$faker->paragraphs(rand(10,15), true),
    return [
        'name' => $faker->sentence(7,11),
        'shortcut' => Str::random(9),
        'calendar_week' => rand(0,52),
        'employee_id' => '1',
        'estimated_hours' => rand(10,100),
        'workonday' => date('Y-m-d H:i:s'),
        'dead' => date('Y-m-d H:i:s'),
    ];
});
