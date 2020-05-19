<?php

namespace Tests\Feature;

use App\Mail\BookingConfirmation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Event;
use App\Booking;

class CancelBookingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();

        config(['app.cancelation_redirect_url' => 'https://company.com/canceled']);
    }

    /** @test */
    public function a_guest_can_cancel_a_booking()
    {
        $booking = factory(Booking::class)->create();

        $response = $this->get($booking->cancelationUrl());

        $response->assertRedirect('https://company.com/canceled');
        $this->assertEquals('canceled', $booking->fresh()->status);
        $this->assertEquals($booking->event->capacity, $booking->event->availableSeats());
    }
}
