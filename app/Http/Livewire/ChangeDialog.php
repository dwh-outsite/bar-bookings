<?php

namespace App\Http\Livewire;

use App\Booking;
use App\Http\Middleware\BarAuthentication;
use Livewire\Component;

class ChangeDialog extends Component
{
    public $state = 'inactive';

    public $booking;

    protected $listeners = [
        'booking-change' => 'handleBookingChange'
    ];

    public function hydrate()
    {
        BarAuthentication::authenticate(request());
    }

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

    public function addNewTablePlacement($tableNumber)
    {
        $this->booking->tablePlacements()->create(['table_number' => $tableNumber]);
    }

    public function render()
    {
        if (!is_null($this->booking)) {
            $this->booking->refresh();
        }

        return view('livewire.change-dialog');
    }
}
