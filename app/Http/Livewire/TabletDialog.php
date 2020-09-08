<?php

namespace App\Http\Livewire;

use App\Booking;
use App\Events\PersonalInformationEnteredOnTablet;
use App\Http\Middleware\BarAuthentication;
use Livewire\Component;

class TabletDialog extends Component
{
    public $state = 'inactive';

    public $booking;

    protected $listeners = [
        'visitor-details-form-completed' => 'handleVisitorDetailsFormCompleted'
    ];

    public function hydrate()
    {
        BarAuthentication::authenticate(request());
    }

    public function showVisitorCode($booking)
    {
        $this->booking = Booking::find($booking['id']);

        $this->state = 'visitor_code';

        $this->emit('tablet-show-visitor-code', $this->booking->visitor_code);
    }

    public function showDetailsForm($booking)
    {
        $this->booking = Booking::find($booking['id']);

        $this->state = 'details_form';
    }

    public function handleVisitorDetailsFormCompleted()
    {
        $this->close();

        event(new PersonalInformationEnteredOnTablet());
    }

    public function close()
    {
        $this->state = 'inactive';

        $this->reset();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.tablet-dialog');
    }
}
