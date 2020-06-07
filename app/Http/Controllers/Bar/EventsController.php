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
        $futureEvents = Event::endDateInTheFuture(6)->orderBy('start')->get();

        return view('bar.events.index', compact('futureEvents'));
    }

    /**
     * Display the specified resource.
     *
     * @param Event $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('bar.events.show', compact('event'));
    }
}
