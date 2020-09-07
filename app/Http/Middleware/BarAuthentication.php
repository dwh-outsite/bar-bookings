<?php

namespace App\Http\Middleware;

class BarAuthentication extends TokenAuthentication
{
    public static function token(): string
    {
        return config('app.bar_area_token');
    }
}
