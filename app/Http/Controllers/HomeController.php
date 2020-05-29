<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $futureEvents = Event::endDateInTheFuture()->orderBy('start')->get();
        $pastEvents = Event::endDateInThePast()->orderBy('start', 'desc')->get();

        return view('home', compact('futureEvents', 'pastEvents'));
    }
}
