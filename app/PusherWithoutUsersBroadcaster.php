<?php

namespace App;


use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;

class PusherWithoutUsersBroadcaster extends PusherBroadcaster
{
    /**
     * Authenticate the incoming request for a given channel.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     *
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function auth($request)
    {
        return parent::verifyUserCanAccessChannel(
            $request,
            $this->normalizeChannelName($request->channel_name)
        );
    }
}
