<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Project::class, function (Faker $faker) {
    //
    return [
        'name' => $faker->word(),
        'description'=>$faker->paragraphs(rand(0,2), true),
        'employee_id' => rand(1,10),
        'shortcut' => Str::random(rand(4,6)),
        'estimated_hours' => rand(10,100),
        'start' => $faker->dateTimeBetween('-3 days','now'),
        'dead' => $faker->dateTimeBetween('now','30 days'),
    ];
});
