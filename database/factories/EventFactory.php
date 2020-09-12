<?php

namespace Database\Factories;

use App\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start = $this->faker->dateTimeBetween('tomorrow', '+1 month');
        $end = (new Carbon($start))->addHours(2);

        return [
            'event_type_id' => 'bar',
            'name' => $this->faker->randomElement(['Bar Night 3000', 'Bar Night', 'Bar Night Deluxe', 'SPILL. THE. TEA. HOUR.', 'Karaoke Festival', 'Sjoelen (65+)', 'SYLA 2.0', 'Dinner for a Winner']),
            'capacity' => $this->faker->numberBetween(10, 50),
            'twoseat_capacity' => $this->faker->numberBetween(0, 5),
            'start' => $start,
            'end' => $end,
        ];
    }

    public function past()
    {
        return $this->state(function () {

            $start = $this->faker->dateTimeBetween('-1 month', 'yesterday');
            $end = (new Carbon($start))->addHours(2);

            return [
                'start' => $start,
                'end' => $end,
            ];
        });
    }
}
