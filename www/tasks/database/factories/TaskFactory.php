<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'due_date' => $faker->dateTime,
        'is_done' => $faker->boolean(25),
        'deleted_at' => $faker->randomElement(null, $faker->dateTime),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime
    ];
});
