<?php

namespace Tests\Feature\Admin;

use App\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_see_events()
    {
        $response = $this->get(route('events.index'));

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

        $response = $this->get(route('events.index'));

        $response->assertSee('Bar Night Lite');
        $response->assertSee('Bar Night Deluxe');
        $response->assertSee('Bar Night Extra');
        $response->assertSee('Bar Night Royale');
    }

}
