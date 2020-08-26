<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddLeftStatusToBookingStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (config('database.default') !== 'sqlite') {
            DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('active', 'canceled', 'left')");
        }
    }
}
