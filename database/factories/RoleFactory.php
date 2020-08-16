<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Role::class, function (Faker $faker) {
//            'id'=>$id,
    return [
        'name' => $faker->randomElement(['administrator','manager','programmer','tester']),
    ];
});
