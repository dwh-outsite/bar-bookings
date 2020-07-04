<?php

namespace Tests\Feature\Bar;

use App\Booking;
use App\Event;
use App\Http\Livewire\InteractiveBookings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PresenceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_bartender_can_mark_a_guest_a_present()
    {
        $event = factory(Event::class)->create();
        $booking = factory(Booking::class)->create(['event_id' => $event->id]);

        $this->assertFalse($booking->refresh()->isPresent());

        Livewire::test(InteractiveBookings::class, ['title' => 'Active', 'event' => $event])
            ->call('markAsPresent', $booking->id);

        $this->assertTrue($booking->refresh()->isPresent());
    }

    /** @test */
    public function a_bartender_can_unmark_a_guest_a_present()
    {
        $event = factory(Event::class)->create();
        $booking = factory(Booking::class)->state('present')->create(['event_id' => $event->id]);

        $this->assertTrue($booking->refresh()->isPresent());

        Livewire::test(InteractiveBookings::class, ['title' => 'Active', 'event' => $event])
            ->call('unmarkAsPresent', $booking->id);

        $this->assertFalse($booking->refresh()->isPresent());
    }
}
