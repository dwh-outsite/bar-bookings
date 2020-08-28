<?php

namespace App\Providers;

use App\Http\Middleware\BarAuthentication;
use App\PusherWithoutUsersBroadcaster;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;
use Pusher\Pusher;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::extend('pusher-custom', function ($app, array $config) {
            $pusher = new Pusher(
                $config['key'], $config['secret'],
                $config['app_id'], $config['options'] ?? []
            );

            if ($config['log'] ?? false) {
                $pusher->setLogger($app->make(LoggerInterface::class));
            }

            return new PusherWithoutUsersBroadcaster($pusher);
        });

        Broadcast::routes([
            'middleware' => ['web', BarAuthentication::class]
        ]);

        require base_path('routes/channels.php');
    }
}
