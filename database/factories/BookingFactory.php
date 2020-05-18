<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Booking;
use Faker\Generator as Faker;

$factory->define(Booking::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'event_id' => fn () => factory(\App\Event::class)->create()->id,
    ];
});
