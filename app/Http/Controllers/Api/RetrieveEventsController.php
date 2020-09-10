<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Resources\Event as EventResource;
use App\Log;
use Illuminate\Http\Request;

class RetrieveEventsController extends Controller
{
    public function __invoke(Request $request)
    {
        Log::create(['ip' => $request->ip()]);

        return EventResource::collection(
            Event::endDateInTheFuture()
                ->when($request->has('event_type_id'), fn ($query) => $query->where('event_type_id', $request->event_type_id))
                ->orderBy('start')
                ->get()
        );
    }
}
