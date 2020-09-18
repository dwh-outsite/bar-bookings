<?php

namespace App\Console\Commands;

use App\Booking;
use Illuminate\Console\Command;

class AnonymizeOldBookings extends Command
{
    protected $signature = 'bookings:anonymize';
    protected $description = 'Anonymize bookings older than 14 days.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Booking::query()
            ->where('created_at', '<', now()->subDays(14))
            ->update([
                'name' => '[anonymized]',
                'email' => '[anonymized]',
                'phone_number' => '[anonymized]',
            ]);

        return 0;
    }
}
