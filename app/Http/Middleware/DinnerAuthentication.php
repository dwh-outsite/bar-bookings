<?php

namespace App\Http\Middleware;

class DinnerAuthentication extends TokenAuthentication
{
    public static function token(): string
    {
        return config('app.dinner_token');
    }
}
