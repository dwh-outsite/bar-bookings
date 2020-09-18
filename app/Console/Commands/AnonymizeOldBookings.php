<?php

namespace App\Console\Commands;

use App\Booking;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class AnonymizeOldBookings extends Command
{
    protected $signature = 'bookings:anonymize';
    protected $description = 'Anonymize bookings older than 14 days.';

    public function handle()
    {
        Booking::query()
            ->whereHas('event', function (Builder $eventQuery) {
                $eventQuery->where('end', '<', now()->subDays(14));
            })
            ->update([
                'name' => '[anonymized]',
                'email' => '[anonymized]',
                'phone_number' => '[anonymized]',
            ]);

        return 0;
    }
}
