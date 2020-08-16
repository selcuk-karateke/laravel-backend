<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Employee::class, function (Faker $faker) {
//            'id'=>$id,
//            'password'=>bcrypt('secret'),
//            'email'=>$faker->unique()->safeEmail,
    return [
        'forename' => $faker->firstName,
        'surename' => $faker->lastName,
        'role_id' => $faker->numberBetween(1,4),
        'email' => $faker->unique()->safeEmail,
        'www' => $faker->unique()->domainName,
    ];
});
