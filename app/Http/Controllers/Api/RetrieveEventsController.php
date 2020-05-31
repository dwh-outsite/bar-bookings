<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Resources\Event as EventResource;
use Illuminate\Http\Request;

class RetrieveEventsController extends Controller
{
    public function __invoke(Request $request)
    {
        return EventResource::collection(Event::endDateInTheFuture()->orderBy('start')->get());
    }
}
