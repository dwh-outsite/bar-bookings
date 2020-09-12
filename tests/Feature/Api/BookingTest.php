<?php

namespace Tests\Feature;

use App\Booking;
use App\Mail\BookingConfirmation;
use Database\Factories\BookingFactory;
use Database\Factories\EventFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

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

        $event = EventFactory::new()->create();

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
    public function a_guest_can_make_a_booking_with_ggd_consent()
    {
        $this->withoutExceptionHandling();

        $event = EventFactory::new()->create();

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl',
            'ggd_consent' => true,
            'phone_number' => '0612345678'
        ]);

        $response->assertSuccessful();
        $booking = Booking::findOrFail(1);
        $this->assertTrue($booking->ggd_consent);
        $this->assertEquals('0612345678', $booking->phone_number);
    }

    /** @test */
    public function a_guest_can_make_a_booking_without_ggd_consent()
    {
        $this->withoutExceptionHandling();

        $event = EventFactory::new()->create();

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl',
            'ggd_consent' => false,
        ]);

        $response->assertSuccessful();
        $booking = Booking::findOrFail(1);
        $this->assertFalse($booking->ggd_consent);
    }

    /** @test */
    public function a_guest_can_make_a_twoseat_booking()
    {
        $this->withoutExceptionHandling();

        $event = EventFactory::new()->state(['capacity' => 10, 'twoseat_capacity' => 4])->create();

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
        $event = EventFactory::new()->create();

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

        $pastEvent = EventFactory::new()->past()->create();
        $futureEvent = EventFactory::new()->create();

        BookingFactory::new()->state([
            'event_id' => $pastEvent->id,
            'email' => 'booking@casperboone.nl'
        ])->create();

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
        $canceledBooking = BookingFactory::new()->state([
            'status' => 'canceled',
            'email' => 'booking@casperboone.nl',
        ])->create();

        $event = EventFactory::new()->create();

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
        $event = EventFactory::new()->create();

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
    public function a_guest_cannot_make_two_bookings_for_the_same_event_type()
    {
        $eventA = EventFactory::new()->state(['event_type_id' => 'bar'])->create();
        $eventB = EventFactory::new()->state(['event_type_id' => 'bar'])->create();

        $responseA = $this->postJson('/api/bookings', [
            'event_id' => $eventA->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $responseB = $this->postJson('/api/bookings', [
            'event_id' => $eventB->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $responseA->assertSuccessful();
        $responseB->assertStatus(422);
        $this->assertEquals(1, Booking::count());
        Mail::assertQueued(BookingConfirmation::class, 1);
    }

    /** @test */
    public function a_guest_can_make_two_bookings_for_events_of_a_different_type()
    {
        $eventBar = EventFactory::new()->state(['event_type_id' => 'bar'])->create();
        $eventDinner = EventFactory::new()->state(['event_type_id' => 'dinner'])->create();

        $responseA = $this->postJson('/api/bookings', [
            'event_id' => $eventBar->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl'
        ]);

        $responseB = $this->postJson('/api/bookings', [
            'event_id' => $eventDinner->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl',
            'custom_fields' => ['team' => 'cookies']
        ]);

        $responseA->assertSuccessful();
        $responseB->assertSuccessful();
        $this->assertEquals(2, Booking::count());
        Mail::assertQueued(BookingConfirmation::class, 2);
    }

    /** @test */
    public function a_guest_cannot_make_a_booking_with_ggd_consent_but_without_a_phone_number()
    {
        $event = EventFactory::new()->create();

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl',
            'ggd_consent' => true
        ]);

        $response->assertStatus(422);
        $this->assertEquals(0, Booking::count());
        Mail::assertQueued(BookingConfirmation::class, 0);
    }

    /** @test */
    public function a_guest_cannot_make_a_booking_if_an_event_is_full()
    {
        $event = EventFactory::new()->state(['capacity' => 30])->create();
        BookingFactory::new()->state(['event_id' => $event->id])->count(30)->create();

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
        $event = EventFactory::new()->state(['capacity' => 3, 'twoseat_capacity' => 2])->create();
        BookingFactory::new()->state(['event_id' => $event->id, 'twoseat' => true])->count(2)->create();

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
        $event = EventFactory::new()->state(['capacity' => 3, 'twoseat_capacity' => 2])->create();
        BookingFactory::new()->state(['event_id' => $event->id, 'twoseat' => true])->count(2)->create();

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
        $event = EventFactory::new()->create();

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

    /** @test */
    public function a_guest_can_make_a_booking_with_custom_fields()
    {
        $this->withoutExceptionHandling();

        $event = EventFactory::new()->state([
            'event_type_id' => 'dinner',
        ])->create();

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl',
            'custom_fields' => [
                'diet' => ['Meat', 'Fish'],
                'team' => 'Cooking',
            ]
        ]);

        $response->assertSuccessful();

        $booking = Booking::findOrFail(1);

        $this->assertEquals(['Meat', 'Fish'], $booking->custom_fields['diet']);
        $this->assertEquals('Cooking', $booking->custom_fields['team']);
    }

    /** @test */
    public function a_guest_cannot_make_a_booking_with_invalid_or_missing_custom_fields()
    {
        $event = EventFactory::new()->state([
            'event_type_id' => 'dinner',
        ])->create();

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl',
            'custom_fields' => [
                'diet' => 'should be an array',
                'team' => 'Cooking',
            ]
        ]);

        $response->assertStatus(422);

        $this->assertEquals(0, Booking::count());
    }

    /** @test */
    public function a_guest_can_make_a_booking_with_extra_custom_fields_but_those_are_filtered()
    {
        $event = EventFactory::new()->state([
            'event_type_id' => 'dinner',
        ])->create();

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl',
            'custom_fields' => [
                'diet' => [],
                'team' => 'Cooking',
                'non_existing_field' => 'the value'
            ]
        ]);

        $response->assertStatus(422);

        $this->assertEquals(0, Booking::count());
    }

    /** @test */
    public function a_guest_can_make_a_booking_with_custom_fields_for_the_wrong_event_but_those_are_filtered()
    {
        $event = EventFactory::new()->state([
            'event_type_id' => 'bar',
        ])->create();

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'name' => 'Casper',
            'email' => 'booking@casperboone.nl',
            'custom_fields' => [
                'diet' => ['Meat', 'Fish'],
                'team' => 'Cooking',
            ]
        ]);

        $response->assertStatus(422);

        $this->assertEquals(0, Booking::count());
    }
}
