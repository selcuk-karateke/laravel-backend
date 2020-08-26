<?php

/** @var Factory $factory */

use App\Project;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Project::class, function (Faker $faker) {
    //
    return [
        'name' => $faker->word(),
        'from_api' => 0,
        'description'=> $faker->paragraphs(rand(0,2), true),
        'descr_short'=> $faker->paragraphs(rand(0,1), true),
//        'employee_id' => rand(1,10),
        'shortcut' => Str::random(rand(4,6)),
        'estimated_hours' => rand(10,200),
        'actual_hours' => rand(10,150),
        'start' => $faker->dateTimeBetween('-60 days','now'),
        'dead' => $faker->dateTimeBetween('now','120 days'),
    ];
});
