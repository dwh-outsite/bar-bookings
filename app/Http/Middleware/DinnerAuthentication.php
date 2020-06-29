<?php

namespace App\Http\Middleware;

class DinnerAuthentication extends TokenAuthentication
{
    public function token(): string
    {
        return config('app.dinner_token');
    }
}
