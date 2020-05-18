<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Event;
use App\Booking;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_can_make_a_booking()
    {
        $event = factory(Event::class)->create();

        $response = $this->post('/', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $response->assertStatus(200);
        $booking = Booking::findOrFail(1);
        $this->assertTrue($event->is($booking->event));
        $this->assertEquals('Casper', $booking->name);
        $this->assertEquals('booking@casperboone.nl', $booking->email);
    }

    /** @test */
    public function multiple_guests_can_make_a_booking_for_the_same_event()
    {
        $event = factory(Event::class)->create();

        $responseA = $this->post('/', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl'
        ]);
        $responseB = $this->post('/', [
            'event_id' => $event->id,
            'name' => 'Henk',
            'email' => 'booking@henk.nl'
        ]);

        $responseA->assertStatus(200);
        $responseB->assertStatus(200);
        $this->assertEquals(2, Booking::count());
    }

    /** @test */
    public function a_guest_cannot_make_two_bookings_for_the_same_event()
    {
        $event = factory(Event::class)->create();

        $responseA = $this->post('/', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $responseB = $this->post('/', [
            'event_id' => $event->id,
            'name' => 'Not Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $responseA->assertStatus(200);
        $responseB->assertStatus(422);
        $this->assertEquals(1, Booking::count());
    }

    /** @test */
    public function a_guest_cannot_make_two_bookings_for_two_different_events()
    {
        $eventA = factory(Event::class)->create();
        $eventB = factory(Event::class)->create();

        $responseA = $this->post('/', [
            'event_id' => $eventA->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $responseB = $this->post('/', [
            'event_id' => $eventB->id,
            'name' => 'Not Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $responseA->assertStatus(200);
        $responseB->assertStatus(422);
        $this->assertEquals(1, Booking::count());
    }

    /** @test */
    public function a_guest_cannot_make_a_booking_if_an_event_is_full()
    {
        $event = factory(Event::class)->create(['capacity' => 30]);
        factory(Booking::class, 30)->create(['event_id' => $event->id]);

        $response = $this->post('/', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $response->assertStatus(422);
        $this->assertEquals(0, Booking::count());
    }
}
