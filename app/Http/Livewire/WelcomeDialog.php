<?php

namespace App\Http\Livewire;

use App\Booking;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WelcomeDialog extends Component
{
    public $states = [
        'name' => 'Name',
        'health_check' => 'Health Check',
        'ggd_consent' => 'GGD Consent and Personal Information',
    ];
    public $state = 'inactive';

    public $event_id;
    public $booking;

    public string $name = '';
    public bool $health_check = false;
    public bool $ggd_consent = false;
    public string $email = '';
    public string $phone_number = '';
    public $twoseat = false;

    protected $listeners = [
        'new-guest' => 'handleNewGuest',
        'booking-present' => 'handleBookingPresent'
    ];
    protected $casts = [
        'twoseat' => BooleanCaster::class
    ];

    public function mount($event)
    {
        $this->event_id = $event->id;
    }

    public function handleNewGuest()
    {
        $this->state = array_keys($this->states)[0];
    }

    public function handleBookingPresent($id) {
        $this->booking = Booking::find($id);

        $this->name = $this->booking->name;
        $this->ggd_consent = $this->booking->ggd_consent;
        $this->email = $this->booking->email ?? '';
        $this->phone_number = $this->booking->phone_number ?? '';
        $this->twoseat = $this->booking->twoseat;

        $this->state = array_keys($this->states)[0];
    }

    public function back()
    {
        $this->state = array_keys($this->states)[array_search($this->state, array_keys($this->states)) - 1];
    }

    public function next()
    {
        $this->state = array_keys($this->states)[array_search($this->state, array_keys($this->states)) + 1];
    }

    public function close()
    {
        $this->state = 'inactive';

        $this->reset('name', 'ggd_consent', 'email', 'phone_number', 'twoseat', 'health_check', 'booking');
        $this->resetValidation();
    }

    public function register()
    {
        return DB::transaction(function () {
            $data = $this->validate(Booking::rules($this->event_id, false, false));

            if (is_null($this->booking)) {
                $booking = Booking::create($data);
            } else {
                $booking = $this->booking;
                $booking->update($data);
            }

            $booking->markAsPresent();

            $this->emit('booking-changed');

            $this->close();
        });
    }

    public function render()
    {
        return view('livewire.welcome-dialog');
    }
}
