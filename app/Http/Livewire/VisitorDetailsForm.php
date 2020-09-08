<?php

namespace App\Http\Livewire;

use App\Booking;
use Livewire\Component;

class VisitorDetailsForm extends Component
{
    public $booking;

    public string $name = '';
    public bool $ggd_consent = false;
    public string $email = '';
    public string $phone_number = '';

    public function mount($booking)
    {
        $this->booking = $booking;

        $this->name = $booking->name;
        $this->ggd_consent = $booking->ggd_consent;
        $this->email = $booking->email;
        $this->phone_number = $booking->phone_number;
    }

    public function update()
    {
        $this->booking->update(array_merge(
            $this->validate(Booking::visitorRules()),
            ['visitor_details_form_completed' => true]
        ));

        $this->emit('visitor-details-form-completed');

        $this->reset();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.visitor.visitor-details-form');
    }
}
