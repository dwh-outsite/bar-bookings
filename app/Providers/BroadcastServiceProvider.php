<?php

namespace App\Providers;

use App\Http\Middleware\BarAuthentication;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes([
            'middleware' => ['web', BarAuthentication::class]
        ]);

        require base_path('routes/channels.php');
    }
}
