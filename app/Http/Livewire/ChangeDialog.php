<?php

namespace App\Http\Livewire;

use App\Booking;
use Livewire\Component;

class ChangeDialog extends Component
{
    public $state = 'inactive';

    public $booking;

    protected $listeners = [
        'booking-change' => 'handleBookingChange'
    ];

    public function handleBookingChange($id)
    {
        $this->booking = Booking::find($id);
        $this->state = 'active';
    }

    public function close()
    {
        $this->reset();
    }

    public function markAsLeft()
    {
        $this->booking->markAsLeft();

        $this->emit('booking-changed');

        $this->close();
    }

    public function render()
    {
        return view('livewire.change-dialog');
    }
}
