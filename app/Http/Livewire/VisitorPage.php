<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VisitorPage extends Component
{
    public $booking;

    public $state;

    protected $listeners = [
        'visitor-details-form-completed' => 'handleVisitorDetailsFormCompleted'
    ];

    public function mount($booking)
    {
        $this->booking = $booking;

        $this->state = $booking->visitor_details_form_completed ? 'inactive' : 'form';
    }

    public function handleVisitorDetailsFormCompleted()
    {
        $this->booking->refresh();

        $this->state = 'inactive';
    }

    public function openForm()
    {
        $this->state = 'form';
    }

    public function render()
    {
        return view('livewire.visitor.visitor-page');
    }
}
