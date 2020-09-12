<?php

namespace Tests\Feature;

use App\Mail\BookingCanceled;
use Database\Factories\BookingFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

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
        $booking = BookingFactory::new()->state(['email' => 'booking@casperboone.nl'])->create();

        $response = $this->get($booking->cancelationUrl());

        $response->assertRedirect('https://company.com/canceled');
        $this->assertEquals('canceled', $booking->fresh()->status);
        $this->assertEquals($booking->event->capacity, $booking->event->availableSeats());
        Mail::assertQueued(BookingCanceled::class, function (BookingCanceled $mail) use ($booking) {
            return $mail->booking->is($booking)
                && $mail->hasTo('booking@casperboone.nl');
        });
    }
}
