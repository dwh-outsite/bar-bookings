<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});

Broadcast::channel('tablet', function ($user) {
    // There is likely no authenticated user, since authentication for the table and bar screen is handled through
    // middleware, therefore the same middleware is applied to the authentication route in the BroadcastServiceProvider.
    return true;
});
