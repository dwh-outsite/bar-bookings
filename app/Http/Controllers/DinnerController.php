<?php

namespace App\Http\Controllers;

use App\Event;

class DinnerController
{
    public function __invoke()
    {
        return view('dinner', [
            'event' => Event::query()->whereEventTypeId('dinner')->endDateInTheFuture()->orderBy('end')->firstOrFail(),
        ]);
    }
}
