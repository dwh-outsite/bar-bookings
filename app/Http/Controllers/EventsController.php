<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventType;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $futureEvents = Event::endDateInTheFuture()->orderBy('start')->get();
        $pastEvents = Event::endDateInThePast()->orderBy('start', 'desc')->get();

        return view('admin.events.index', compact('futureEvents', 'pastEvents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.events.form', ['title' => 'Create New Event', 'eventTypes' => EventType::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = Event::create($this->validateEvent($request));

        return redirect(route('admin.events.show', $event))
            ->with('status', 'Event "'.$event->name.'" has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('admin.events.form', [
            'title' => "Edit {$event->name}",
            'event' => $event,
            'eventTypes' => EventType::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $event->update($this->validateEvent($request));

        return redirect(route('admin.events.show', $event))
            ->with('status', 'Event "'.$event->name.'" has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->bookings()->each(fn ($booking) => $booking->cancel());

        $event->delete();

        return redirect(route('admin.events.index'))
            ->with('status', 'Event "'.$event->name.'" has been removed successfully. A cancelation e-mail will be sent to the bookers.');
    }

    private function validateEvent($request) {
        return $request->validate([
            'event_type_id' => 'required|string',
            'name' => 'required|string',
            'capacity' => 'required|integer',
            'twoseat_capacity' => 'required|integer',
            'start' => 'required|date|after:now',
            'end' => 'required|date|after:start',
        ]);
    }
}
