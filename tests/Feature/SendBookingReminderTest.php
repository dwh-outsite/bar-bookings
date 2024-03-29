<?php

namespace Tests\Feature;

use App\Console\Commands\SendBookingReminders;
use App\Mail\BookingReminder;
use Database\Factories\BookingFactory;
use Database\Factories\EventFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendBookingReminderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function send_booking_reminder_when_the_event_starts_in_six_hours()
    {
        Mail::fake();
        $event = EventFactory::new()->state(['start' => now()->addHours(4)]);
        BookingFactory::new()->for($event)->state([
            'email' => 'henk@online.nl',
            'created_at' => now()->subDay()
        ])->create();

        $this->artisan(SendBookingReminders::class);

        Mail::assertQueued(BookingReminder::class, function (BookingReminder $mail) {
            return $mail->hasTo('henk@online.nl');
        });
    }

    /** @test */
    public function send_only_one_reminder_when_the_command_is_executed_twice()
    {
        Mail::fake();
        $event = EventFactory::new()->state(['start' => now()->addHours(4)]);
        BookingFactory::new()->for($event)->state([
            'email' => 'henk@online.nl',
            'created_at' => now()->subDay()
        ])->create();

        $this->artisan(SendBookingReminders::class);
        $this->artisan(SendBookingReminders::class);

        Mail::assertQueued(BookingReminder::class, 1);
    }

    /** @test */
    public function do_not_remind_the_guest_when_they_made_the_booking_within_the_remind_frame()
    {
        Mail::fake();
        $event = EventFactory::new()->state(['start' => now()->addHours(4)]);
        BookingFactory::new()->for($event)->state([
            'email' => 'henk@online.nl',
            'created_at' => now()
        ])->create();

        $this->artisan(SendBookingReminders::class);

        Mail::assertNothingQueued();
    }

    /** @test */
    public function do_not_remind_the_guest_after_the_event_has_started_and_it_is_past_midnight()
    {
        Mail::fake();
        Carbon::setTestNow(now()->addDay()->setTime(0, 5, 0, 0));
        $event = EventFactory::new()->state(['start' => now()->addHours(-2)]);
        BookingFactory::new()->for($event)->state([
            'email' => 'henk@online.nl',
            'created_at' => now()->subHour()
        ])->create();

        $this->artisan(SendBookingReminders::class);

        Mail::assertNothingQueued();
    }

    /** @test */
    public function do_not_remind_the_guest_after_the_event_has_started()
    {
        Mail::fake();
        $event = EventFactory::new()->state(['start' => now()->addHours(-4)]);
        BookingFactory::new()->for($event)->state([
            'email' => 'henk@online.nl',
            'created_at' => now()->subHours(24)
        ])->create();

        $this->artisan(SendBookingReminders::class);

        Mail::assertNothingQueued();
    }

    /** @test */
    public function do_not_remind_the_guest_when_a_booking_is_not_within_the_remind_frame()
    {
        Mail::fake();
        $event = EventFactory::new()->state(['start' => now()->addHours(7)]);
        BookingFactory::new()->for($event)->state([
            'email' => 'henk@online.nl',
            'created_at' => now()->subDay()
        ])->create();

        $this->artisan(SendBookingReminders::class);

        Mail::assertNothingQueued();
    }

    /** @test */
    public function do_not_remind_the_guest_when_their_booking_is_canceled()
    {
        Mail::fake();
        $event = EventFactory::new()->state(['start' => now()->addHours(4)]);
        BookingFactory::new()->for($event)->state([
            'email' => 'henk@online.nl',
            'created_at' => now()->subDay()
        ])->canceled()->create();

        $this->artisan(SendBookingReminders::class);

        Mail::assertNothingQueued();
    }
}
