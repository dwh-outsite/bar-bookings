<?php

namespace Database\Factories;

use App\Booking;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'event_id' => EventFactory::new(),
        ];
    }

    public function canceled()
    {
        return $this->state([
            'status' => 'canceled',
        ]);
    }

    public function twoseat()
    {
        return $this->state([
            'twoseat' => true,
        ]);
    }

    public function present()
    {
        return $this->state([
            'present' => Carbon::now()->subMinute(),
        ]);
    }
}
