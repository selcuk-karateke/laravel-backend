<?php

/** @var Factory $factory */

use App\Task;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Task::class, function (Faker $faker) {
    //
    return [
        'name'=> $faker->word(),
        'description'=> $faker->paragraphs(rand(0,1), true),
        'status'=> $faker->randomElement(['On Going','Stopped','Done','On Line']),
        'employee_id' => rand(1,10),
        'project_id' => rand(1,10),
        'estimated_hours'=> rand(10,100),
        'real_hours'=> rand(50,200),
        'calendar_week' => rand(0,52),
//        'workonday' => date('Y-m-d H:i:s'),
        'task_end'=> $faker->dateTimeBetween('now','30 days'),
        'real_end'=> $faker->dateTimeBetween('now','50 days'),
        'charged'=>rand(0,1),
    ];
});
