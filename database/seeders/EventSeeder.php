<?php

namespace Database\Seeders;

use Database\Factories\BookingFactory;
use Database\Factories\EventFactory;
use Faker\Provider\Base as Faker;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $futureEvents =  EventFactory::new()
            ->count(8)
            ->create();

        $pastEvents =  EventFactory::new()
            ->past()
            ->count(4)
            ->create();

        $futureEvents->merge($pastEvents)
            ->each(function ($event) {
               BookingFactory::times(Faker::numberBetween(0, $event->capacity))
                   ->state(['event_id' => $event->id])
                   ->create();

               BookingFactory::times(Faker::numberBetween(0, $event->twoseat_capacity))
                   ->twoseat()
                   ->state(['event_id' => $event->id])
                   ->create();

               BookingFactory::times(Faker::numberBetween(0, 10))
                   ->canceled()
                   ->state(['event_id' => $event->id])
                   ->create();
            });
    }
}
