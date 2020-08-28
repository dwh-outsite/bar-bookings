<?php

namespace App\Http\Controllers\Bar;

use App\Http\Controllers\Controller;

class TabletController extends Controller
{
    public function __invoke()
    {
        return view('bar.tablet');
    }
}
