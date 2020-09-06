<?php

namespace App\Http\Livewire;

use App\Booking;
use App\Events\ActivateTablet;
use App\Events\DeactivateTablet;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WelcomeDialog extends Component
{
    public $states = [
        'name' => 'Name',
        'health_check' => 'Health Check',
        'ggd_consent' => 'GGD Consent and Personal Information',
        'table_selection' => 'Table Placement'
    ];
    public $state = 'inactive';

    public $event;
    public $booking;

    public string $name = '';
    public bool $health_check = false;
    public bool $ggd_consent = false;
    public string $email = '';
    public string $phone_number = '';
    public $twoseat = false;
    public $table_number;
    public $event_id;

    protected $listeners = [
        'new-guest' => 'handleNewGuest',
        'booking-present' => 'handleBookingPresent'
    ];
    protected $casts = [
        'twoseat' => BooleanCaster::class
    ];

    public function mount($event)
    {
        $this->event = $event;
        $this->event_id = $event->id;  // required for form validation
    }

    public function handleNewGuest()
    {
        $this->state = array_keys($this->states)[0];
    }

    public function handleBookingPresent($id)
    {
        $this->booking = Booking::find($id);

        $this->name = $this->booking->name;
        $this->ggd_consent = $this->booking->ggd_consent;
        $this->email = $this->booking->email ?? '';
        $this->phone_number = $this->booking->phone_number ?? '';
        $this->twoseat = $this->booking->twoseat;

        $this->state = array_keys($this->states)[0];
    }

    public function activateTablet()
    {
        event(new ActivateTablet());
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

        event(new DeactivateTablet());

        $this->reset('name', 'ggd_consent', 'email', 'phone_number', 'twoseat', 'health_check', 'booking', 'table_number');
        $this->resetValidation();
    }

    public function selectTableNumber($number)
    {
        $this->table_number = $number;
    }

    public function register()
    {
        return DB::transaction(function () {
            $data = $this->validate(Booking::barRules());

            if (is_null($this->booking)) {
                $booking = Booking::create($data);
            } else {
                $booking = $this->booking;
                $booking->update($data);
            }

            if ($this->ggd_consent) {
                $this->validate(['table_number' => 'required|int']);

                $booking->tablePlacements()->create(['table_number' => $this->table_number]);
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
