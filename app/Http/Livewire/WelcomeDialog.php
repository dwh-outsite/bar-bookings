<?php

namespace App\Http\Livewire;

use App\Booking;
use App\Events\DeactivateTablet;
use App\Events\ShowDetailsFormOnTablet;
use App\Events\ShowVisitorCodeOnTablet;
use App\Http\Middleware\BarAuthentication;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WelcomeDialog extends Component
{
    public $states = [
        'name' => 'Name',
        'health_check' => 'Health Check',
        'contact_details' => 'Contact Details'
    ];
    public $state = 'inactive';

    public $event;
    public $booking;

    public string $name = '';
    public bool $health_check = false;
    public $twoseat = false;
    public $event_id;

    public $new_guest = false;

    protected $listeners = [
        'new-guest' => 'handleNewGuest',
        'booking-present' => 'handleBookingPresent'
    ];
    protected $casts = [
        'twoseat' => BooleanCaster::class
    ];

    public function hydrate()
    {
        BarAuthentication::authenticate(request());
    }

    public function mount($event)
    {
        $this->event = $event;
        $this->event_id = $event->id;  // required for form validation
    }

    public function handleNewGuest()
    {
        $this->new_guest = true;
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

    public function showContactDetailsOptions()
    {
        $this->state = 'contact_details';

        $this->showVisitorCodeOnTablet();
    }

    public function showVisitorDetailsFormOnTablet()
    {
        event(new ShowDetailsFormOnTablet($this->booking));
    }

    public function showVisitorCodeOnTablet()
    {
        event(new ShowVisitorCodeOnTablet($this->booking));
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

        $this->reset('name', 'twoseat', 'health_check', 'booking', 'new_guest');
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
                $this->booking = Booking::create($data);
            } else {
                $this->booking->update($data);
            }

            $this->booking->markAsPresent();

            $this->emit('booking-changed');

            if ($this->new_guest) {
                $this->showContactDetailsOptions();
            } else {
                $this->close();
            }
        });
    }

    public function render()
    {
        return view('livewire.welcome-dialog');
    }
}
