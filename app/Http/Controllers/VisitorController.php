<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        if (!session()->has('visitor_code') && !$request->has('visitor_code')) {
            return redirect(route('visitor.enter_code'));
        }

        if ($request->has('visitor_code')) {
            session()->put('visitor_code', $request->input('visitor_code'));
        }

        return view('visitor.index', [
            'booking' => Booking::whereVisitorCode(session('visitor_code'))->latest()->firstOrFail()
        ]);
    }

    public function enterCode()
    {
        return view('visitor.enter_code');
    }
}
