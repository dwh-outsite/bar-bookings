<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Booking;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Booking::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'event_id' => fn () => factory(\App\Event::class)->create()->id,
    ];
});

$factory->state(Booking::class, 'canceled', function (Faker $faker) {
    return [
        'status' => 'canceled',
    ];
});

$factory->state(Booking::class, 'twoseat', function (Faker $faker) {
    return [
        'twoseat' => true,
    ];
});

$factory->state(Booking::class, 'present', function (Faker $faker) {
    return [
        'present' => Carbon::now()->subMinute(),
    ];
});
