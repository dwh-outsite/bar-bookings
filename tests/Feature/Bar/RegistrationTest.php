<?php

namespace Tests\Feature\Bar;

use App\Booking;
use App\Event;
use App\Http\Livewire\CreateBooking;
use App\Mail\BookingConfirmation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    // These tests are not exhaustive because most of the behavior that needs to be tested is already covered by the
    // `Api\BookingTest`. The tests below are focused on having a working integration and/or testing the differences
    // compared to the booking api.

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
    }

    /** @test */
    public function a_bartender_can_register_a_guest()
    {
        $event = factory(Event::class)->create();

        Livewire::test(CreateBooking::class, ['event' => $event])
            ->set('name', 'Casper')
            ->set('email', 'booking@casperboone.nl')
            ->set('twoseat', false)
            ->call('create');

        $booking = Booking::findOrFail(1);
        $this->assertTrue($event->is($booking->event));
        $this->assertEquals('Casper', $booking->name);
        $this->assertEquals('booking@casperboone.nl', $booking->email);
        $this->assertFalse($booking->twoseat);
        $this->assertTrue($booking->isPresent());
        Mail::assertNothingQueued(BookingConfirmation::class); // we do not want to send e-mails to on the spot guests
    }

    /** @test */
    public function a_bartender_can_register_a_guest_without_an_email_address()
    {
        $event = factory(Event::class)->create();

        Livewire::test(CreateBooking::class, ['event' => $event])
            ->set('name', 'Casper')
            ->set('twoseat', false)
            ->call('create');

        $booking = Booking::findOrFail(1);
        $this->assertEquals('Casper', $booking->name);
        $this->assertNull($booking->email);
        Mail::assertNothingQueued(BookingConfirmation::class); // we do not want to send e-mails to on the spot guests
    }

    /** @test */
    public function a_bartender_can_register_a_guest_with_a_twoseat()
    {
        $event = factory(Event::class)->create();

        Livewire::test(CreateBooking::class, ['event' => $event])
            ->set('name', 'Casper')
            ->set('twoseat', true)
            ->call('create');

        $booking = Booking::findOrFail(1);
        $this->assertTrue($booking->twoseat);
    }
}
