<?php

namespace App\Http\Controllers\Bar;

use App\Event;
use App\Http\Controllers\Controller;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $futureEvents = $this->scopedOngoingEvents()->orderBy('start')->get();

        return view('bar.events.index', compact('futureEvents'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $eventId
     * @return \Illuminate\Http\Response
     */
    public function show(int $eventId)
    {
        $event = $this->scopedOngoingEvents()->findOrFail($eventId);

        return view('bar.events.show', compact('event'));
    }

    private function scopedOngoingEvents()
    {
        return Event::endDateInTheFuture(6)->hasStarted();
    }
}
