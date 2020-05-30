<?php

namespace Tests\Feature\Admin;

use App\Booking;
use App\Event;
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

        $futureEventA = factory(Event::class)->create(['name' => 'Bar Night Lite']);
        $futureEventB = factory(Event::class)->create(['name' => 'Bar Night Deluxe']);
        $pastEventA = factory(Event::class)->state('past')->create(['name' => 'Bar Night Extra']);
        $pastEventB = factory(Event::class)->state('past')->create(['name' => 'Bar Night Royale']);

        $response = $this->get(route('admin.events.index'));

        $response->assertSee('Bar Night Lite');
        $response->assertSee('Bar Night Deluxe');
        $response->assertSee('Bar Night Extra');
        $response->assertSee('Bar Night Royale');
    }

    /** @test */
    public function a_guest_cannot_see_event_details()
    {
        $event = factory(Event::class)->create();

        $response = $this->get(route('admin.events.show', $event));

        $response->assertRedirect();
    }

    /** @test */
    public function an_admin_can_see_event_details()
    {
        $this->actingAsAdmin();

        $event = factory(Event::class)->create([
            'name' => 'Bar Night Superb',
            'capacity' => 783,
            'start' => Carbon::parse('2020-05-20 18:00'),
            'end' => Carbon::parse('2020-05-20 22:00')
        ]);
        $bookingA = factory(Booking::class)->create(['name' => 'Golden Stark', 'event_id' => $event->id]);
        $bookingB = factory(Booking::class)->create(['name' => 'Viola Hansen', 'event_id' => $event->id]);

        $response = $this->get(route('admin.events.show', $event));

        $response->assertSee('Bar Night Superb');
        $response->assertSee('783');
        $response->assertSee('20-05-2020 18:00');
        $response->assertSee('20-05-2020 22:00');
        $response->assertSee('Golden Stark');
        $response->assertSee('Viola Hansen');
    }
}
