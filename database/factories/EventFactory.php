<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Event::class, function (Faker $faker) {
    $start = $faker->dateTimeBetween('tomorrow', '+1 month');
    $end = (new Carbon($start))->addHours(2);

    return [
        'name' => $faker->name,
        'capacity' => $faker->randomNumber() + 10,
        'start' => $start,
        'end' => $end,
    ];
});

$factory->state(Event::class, 'past', function (Faker $faker) {
    $start = $faker->dateTimeBetween('-1 month', 'yesterday');
    $end = (new Carbon($start))->addHours(2);

    return [
        'start' => $start,
        'end' => $end,
    ];
});
