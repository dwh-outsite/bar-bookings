<?php

namespace Tests\Feature\Admin;

use App\Console\Commands\AnonymizeOldBookings;
use Database\Factories\BookingFactory;
use Database\Factories\EventFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AnonymizeOldBookingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_booking_older_than_14_days_is_anonymized()
    {
        $booking = BookingFactory::new()->state([
            'name' => 'Henk',
            'email' => 'henk@online.nl',
            'phone_number' => '0612345678',
            'event_id' => EventFactory::new()->state(['end' => Carbon::parse('15 days ago')]),
        ])->create();

        $this->artisan(AnonymizeOldBookings::class);

        $booking->refresh();
        $this->assertEquals('[anonymized]', $booking->name);
        $this->assertEquals('[anonymized]', $booking->email);
        $this->assertEquals('[anonymized]', $booking->phone_number);
    }

    /** @test */
    public function a_booking_not_older_than_14_days_is_not_anonymized()
    {
        $booking = BookingFactory::new()->state([
            'name' => 'Henk',
            'email' => 'henk@online.nl',
            'phone_number' => '0612345678',
            'event_id' => EventFactory::new()->state(['end' => Carbon::parse('13 days ago')]),
        ])->create();

        $this->artisan(AnonymizeOldBookings::class);

        $booking->refresh();
        $this->assertEquals('Henk', $booking->name);
        $this->assertEquals('henk@online.nl', $booking->email);
        $this->assertEquals('0612345678', $booking->phone_number);
    }
}
