<?php

namespace Tests\Feature;

use App\Mail\BookingConfirmation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Event;
use App\Booking;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
    }

    /** @test */
    public function a_guest_can_make_a_booking()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $response->assertSuccessful();
        $booking = Booking::findOrFail(1);
        $this->assertTrue($event->is($booking->event));
        $this->assertEquals('Casper', $booking->name);
        $this->assertEquals('booking@casperboone.nl', $booking->email);
        $this->assertFalse($booking->twoseat);
        Mail::assertQueued(BookingConfirmation::class);
    }

    /** @test */
    public function a_guest_can_make_a_twoseat_booking()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create(['capacity' => 10, 'twoseat_capacity' => 4]);

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl',
            'twoseat' => true,
        ]);

        $response->assertSuccessful();
        $booking = Booking::findOrFail(1);
        $this->assertTrue($booking->twoseat);
        $this->assertEquals(9, $event->availableSeats());
        $this->assertEquals(3, $event->availableTwoseats());
        Mail::assertQueued(BookingConfirmation::class);
    }

    /** @test */
    public function multiple_guests_can_make_a_booking_for_the_same_event()
    {
        $event = factory(Event::class)->create();

        $responseA = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl'
        ]);
        $responseB = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Henk',
            'email' => 'booking@henk.nl'
        ]);

        $responseA->assertSuccessful();
        $responseB->assertSuccessful();
        $this->assertEquals(2, Booking::count());
        Mail::assertQueued(BookingConfirmation::class, 2);
    }

    /** @test */
    public function a_guest_can_make_a_booking_for_an_event_in_the_future_after_the_previous_booking_has_expired()
    {
        $this->withoutExceptionHandling();

        $pastEvent = factory(Event::class)->state('past')->create();
        $futureEvent = factory(Event::class)->create();

        factory(Booking::class)->create([
            'event_id' => $pastEvent->id,
            'email' => 'booking@casperboone.nl'
        ]);

        $response = $this->postJson('/api/bookings', [
            'event_id' => $futureEvent->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $response->assertSuccessful();
        $this->assertEquals(2, Booking::count());
        Mail::assertQueued(BookingConfirmation::class);
    }

    /** @test */
    public function a_guest_can_make_a_booking_after_canceling_a_previous_booking()
    {
        $canceledBooking = factory(Booking::class)->create([
            'status' => 'canceled',
            'email' => 'booking@casperboone.nl',
        ]);

        $event = factory(Event::class)->create();

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $response->assertSuccessful();
        $newBooking = Booking::findOrFail(2);
        $this->assertEquals('canceled', $canceledBooking->status);
        $this->assertEquals('active', $newBooking->status);
        Mail::assertQueued(BookingConfirmation::class);
    }

    /** @test */
    public function a_guest_cannot_make_two_bookings_for_the_same_event()
    {
        $event = factory(Event::class)->create();

        $responseA = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $responseB = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Not Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $responseA->assertSuccessful();
        $responseB->assertStatus(422);
        $this->assertEquals(1, Booking::count());
        Mail::assertQueued(BookingConfirmation::class, 1);
    }

    /** @test */
    public function a_guest_can_make_two_bookings_for_two_different_events_in_the_future()
    {
        $eventA = factory(Event::class)->create();
        $eventB = factory(Event::class)->create();

        $responseA = $this->postJson('/api/bookings', [
            'event_id' => $eventA->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $responseB = $this->postJson('/api/bookings', [
            'event_id' => $eventB->id,
            'name' => 'Also Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $responseA->assertSuccessful();
        $responseB->assertSuccessful();
        $this->assertEquals(2, Booking::count());
        Mail::assertQueued(BookingConfirmation::class, 2);
    }

    /** @test */
    public function a_guest_cannot_make_a_booking_if_an_event_is_full()
    {
        $event = factory(Event::class)->create(['capacity' => 30]);
        factory(Booking::class, 30)->create(['event_id' => $event->id]);

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $response->assertStatus(422);
        $this->assertEquals(30, Booking::count());
        $this->assertFalse(Booking::where('email', 'booking@casperboone.nl')->exists());
        Mail::assertNothingQueued();
    }


    /** @test */
    public function a_guest_cannot_make_a_twoseat_booking_if_all_twoseats_are_booked()
    {
        $event = factory(Event::class)->create(['capacity' => 3, 'twoseat_capacity' => 2]);
        factory(Booking::class, 2)->create(['event_id' => $event->id, 'twoseat' => true]);

        $this->assertEquals(1, $event->availableSeats());
        $this->assertEquals(0, $event->availableTwoseats());

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl',
            'twoseat' => true,
        ]);

        $response->assertStatus(422);
        $this->assertFalse(Booking::where('email', 'booking@casperboone.nl')->exists());
        $this->assertEquals(1, $event->availableSeats());
        $this->assertEquals(0, $event->availableTwoseats());
    }

    /** @test */
    public function a_guest_can_make_a_regular_booking_if_all_twoseats_are_booked()
    {
        $event = factory(Event::class)->create(['capacity' => 3, 'twoseat_capacity' => 2]);
        factory(Booking::class, 2)->create(['event_id' => $event->id, 'twoseat' => true]);

        $this->assertEquals(1, $event->availableSeats());
        $this->assertEquals(0, $event->availableTwoseats());

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl',
            'twoseat' => false,
        ]);

        $response->assertStatus(201);
        $this->assertTrue(Booking::where('email', 'booking@casperboone.nl')->exists());
        $this->assertEquals(0, $event->availableSeats());
        $this->assertEquals(0, $event->availableTwoseats());
    }

    /** @test */
    public function a_guest_receives_an_email_after_booking()
    {
        $event = factory(Event::class)->create([
            'name' => '1 juno spektakelfeest',
        ]);

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $response->assertSuccessful();

        $booking = Booking::findOrFail(1);

        Mail::assertQueued(BookingConfirmation::class, function (BookingConfirmation $mail) use ($booking) {
            return $mail->booking->is($booking)
                && $mail->hasTo('booking@casperboone.nl');
        });
    }
}
