<?php

namespace Tests\Feature\Admin;

use Database\Factories\BookingFactory;
use Database\Factories\EventFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_see_events()
    {
        $response = $this->get(route('admin.events.index'));

        $response->assertRedirect();
    }

    /** @test */
    public function an_admin_can_see_events()
    {
        $this->actingAsAdmin();

        $futureEventA = EventFactory::new()->state(['name' => 'Bar Night Lite'])->create();
        $futureEventB = EventFactory::new()->state(['name' => 'Bar Night Deluxe'])->create();
        $pastEventA = EventFactory::new()->past()->state(['name' => 'Bar Night Extra'])->create();
        $pastEventB = EventFactory::new()->past()->state(['name' => 'Bar Night Royale'])->create();

        $response = $this->get(route('admin.events.index'));

        $response->assertSee('Bar Night Lite');
        $response->assertSee('Bar Night Deluxe');
        $response->assertSee('Bar Night Extra');
        $response->assertSee('Bar Night Royale');
    }

    /** @test */
    public function a_guest_cannot_see_event_details()
    {
        $event = EventFactory::new()->create();

        $response = $this->get(route('admin.events.show', $event));

        $response->assertRedirect();
    }

    /** @test */
    public function an_admin_can_see_event_details()
    {
        $this->actingAsAdmin();

        $event = EventFactory::new()->state([
            'name' => 'Bar Night Superb',
            'capacity' => 783,
            'start' => Carbon::parse('2020-05-20 18:00'),
            'end' => Carbon::parse('2020-05-20 22:00')
        ])->create();
        $bookingA = BookingFactory::new()->state(['name' => 'Golden Stark', 'event_id' => $event->id])->create();
        $bookingB = BookingFactory::new()->state(['name' => 'Viola Hansen', 'event_id' => $event->id])->create();

        $response = $this->get(route('admin.events.show', $event));

        $response->assertSee('Bar Night Superb');
        $response->assertSee('783');
        $response->assertSee('20-05-2020 18:00');
        $response->assertSee('20-05-2020 22:00');
        $response->assertSee('Golden Stark');
        $response->assertSee('Viola Hansen');
    }
}
