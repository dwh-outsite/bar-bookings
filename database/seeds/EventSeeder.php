<?php

use Illuminate\Database\Seeder;
use Faker\Provider\Base as Faker;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Event::class, 8)->create()
            ->merge(factory(\App\Event::class, 4)->state('past')->create())
            ->each(
                fn($event) => factory(\App\Booking::class, Faker::numberBetween(0, $event->capacity))->create(['event_id' => $event->id])
                    ->merge(factory(\App\Booking::class, Faker::numberBetween(0, $event->twoseat_capacity))->state('twoseat')->create(['event_id' => $event->id]))
                    ->merge(factory(\App\Booking::class, Faker::numberBetween(0, 10))->state('canceled')->create(['event_id' => $event->id]))
            );
    }
}
