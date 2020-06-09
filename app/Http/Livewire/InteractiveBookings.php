<?php

namespace App\Http\Livewire;

use App\Booking;
use Livewire\Component;

class InteractiveBookings extends Component
{
    public $title;
    public $bookings;
    public $filterActive;
    public $filterPresent;

    protected $listeners = [
        'booking-changed' => '$refresh'
    ];

    public function mount($title, $bookings, $filterActive = null, $filterPresent = null)
    {
        $this->title = $title;
        $this->bookings = $bookings;
        $this->filterActive = $filterActive;
        $this->filterPresent = $filterPresent;
    }

    public function markAsPresent($id)
    {
        $this->bookings->find($id)->markAsPresent();

        $this->emit('booking-changed');
    }

    public function unmarkAsPresent($id)
    {
        $this->bookings->find($id)->unmarkAsPresent();

        $this->emit('booking-changed');
    }

    public function render()
    {
        $visibleBookings = $this->bookings
            ->filter(fn($booking) => is_null($this->filterActive) || $this->filterActive == $booking->isActive())
            ->filter(fn($booking) => is_null($this->filterPresent) || $this->filterPresent == (boolean)$booking->present);

        return view('livewire.interactive-bookings', compact('visibleBookings'));
    }
}
