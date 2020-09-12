<?php

namespace Tests\Feature;

use App\Event;
use Database\Factories\BookingFactory;
use Database\Factories\EventFactory;
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

        $events = EventFactory::new()->count(10)->create();

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
        $events = EventFactory::new()->state([
            'start' => Carbon::now()->subHour(),
            'end' => Carbon::now()->addHour(),
        ])->count(1)->create();

        $response = $this->getJson('/api/events');

        $response->assertSuccessful();
        $this->assertApiResponseContains($response, $events, function ($event) {
            return ['id' => $event->id];
        });
    }

    /** @test */
    public function a_guest_can_filter_bar_events()
    {
        $barEvents = EventFactory::new()->state([
            'event_type_id' => 'bar'
        ])->count(1)->create();
        $dinnerEvents = EventFactory::new()->state([
            'event_type_id' => 'dinner'
        ])->count(1)->create();

        $response = $this->getJson('/api/events?event_type_id=bar');

        $response->assertSuccessful();
        $this->assertApiResponseContains($response, $barEvents, function ($event) {
            return ['id' => $event->id];
        });
        $this->assertApiResponseNotContains($response, $dinnerEvents, function ($event) {
            return ['id' => $event->id];
        });
    }

    /** @test */
    public function a_guest_can_filter_dinner_events()
    {
        $barEvents = EventFactory::new()->state([
            'event_type_id' => 'bar'
        ])->count(1)->create();
        $dinnerEvents = EventFactory::new()->state([
            'event_type_id' => 'dinner'
        ])->count(1)->create();

        $response = $this->getJson('/api/events?event_type_id=dinner');

        $response->assertSuccessful();
        $this->assertApiResponseContains($response, $dinnerEvents, function ($event) {
            return ['id' => $event->id];
        });
        $this->assertApiResponseNotContains($response, $barEvents, function ($event) {
            return ['id' => $event->id];
        });
    }

    /** @test */
    public function a_guest_cannot_retrieve_expired_events()
    {
        $pastEvents = EventFactory::new()->past()->count(10)->create();
        $futureEvents = EventFactory::new()->count(10)->create();

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
        $events = EventFactory::new()->state(['capacity' => '40'])->count(1)->create();
        BookingFactory::new()->state(['event_id' => $events->first()->id])->count(10)->create();

        $response = $this->getJson('/api/events');

        $response->assertSuccessful();
        $this->assertApiResponseContains($response, $events, function ($event) {
            return ['available_seats' => 30];
        });
    }

    private function assertApiResponseContains($response, $collection, $mapping)
    {
        $compare = Event::query()->whereIn('id', $collection->map->id)->orderBy('start')->get();

        $response->assertJson(['data' => $compare->map($mapping)->toArray()]);
    }

    private function assertApiResponseNotContains($response, $collection, $mapping)
    {
        $response->assertJsonMissing(['data' => $collection->map($mapping)->toArray()]);
    }
}
