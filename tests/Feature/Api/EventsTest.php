<?php

namespace Tests\Feature;

use App\Booking;
use App\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_can_retrieve_future_events()
    {
        $this->withoutExceptionHandling();

        $events = factory(Event::class, 10)->create();

        $response = $this->getJson('/api/events');

        $response->assertSuccessful();
        $this->assertApiResponseContains($response, $events, function ($event) {
            return [
                'id' => $event->id,
                'name' => $event->name,
                'capacity' => $event->capacity,
                'available_seats' => $event->capacity,
                'available_twoseats' => $event->twoseat_capacity,
                'start' => $event->start->toJSON(),
                'end' => $event->end->toJSON(),
                'created_at' => $event->created_at->toJSON(),
            ];
        });
    }

    /** @test */
    public function a_guest_can_retrieve_events_going_on_now()
    {
        $events = factory(Event::class, 1)->create([
            'start' => Carbon::now()->subHour(),
            'end' => Carbon::now()->addHour(),
        ]);

        $response = $this->getJson('/api/events');

        $response->assertSuccessful();
        $this->assertApiResponseContains($response, $events, function ($event) {
            return ['id' => $event->id];
        });
    }

    /** @test */
    public function a_guest_cannot_retrieve_expired_events()
    {
        $pastEvents = factory(Event::class, 10)->state('past')->create();
        $futureEvents = factory(Event::class, 10)->create();

        $response = $this->getJson('/api/events');

        $response->assertSuccessful();
        $response->assertJsonCount(10, 'data');
        $this->assertApiResponseContains($response, $futureEvents, function ($event) {
            return ['id' => $event->id];
        });
        $this->assertApiResponseNotContains($response, $pastEvents, function ($event) {
            return ['id' => $event->id];
        });
    }

    /** @test */
    public function a_guest_can_retrieve_the_remaining_available_seats()
    {
        $events = factory(Event::class, 1)->create(['capacity' => '40']);
        factory(Booking::class, 10)->create(['event_id' => $events->first()->id]);

        $response = $this->getJson('/api/events');

        $response->assertSuccessful();
        $this->assertApiResponseContains($response, $events, function ($event) {
            return ['available_seats' => 30];
        });
    }

    private function assertApiResponseContains($response, $collection, $mapping)
    {
        $response->assertJson(['data' => $collection->map($mapping)->toArray()]);
    }

    private function assertApiResponseNotContains($response, $collection, $mapping)
    {
        $response->assertJsonMissing(['data' => $collection->map($mapping)->toArray()]);
    }
}
