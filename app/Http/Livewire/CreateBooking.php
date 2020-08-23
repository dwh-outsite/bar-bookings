<?php

namespace App\Http\Livewire;

use App\Booking;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateBooking extends Component
{
    public $event_id;
    public $name;
    public $email;
    public $phone_number;
    public $ggd_consent = false;
    public $twoseat;

    protected $casts = [
        'twoseat' => BooleanCaster::class
    ];

    public function mount($event)
    {
        $this->event_id = $event->id;
    }

    public function create()
    {
        return DB::transaction(function () {
            $booking = Booking::create($this->validate(Booking::rules($this->event_id, false, false)));

            $booking->markAsPresent();

            $this->emit('booking-changed');

            session()->flash('message', 'Booking has been created succesfully, guest is marked as present.');

            $this->name = '';
            $this->email = '';
            $this->twoseat = false;
        });
    }

    public function render()
    {
        return view('livewire.create-booking');
    }
}
