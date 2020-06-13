<?php

namespace App\Http\Livewire;

use App\Booking;
use Livewire\Component;

class InteractiveBookings extends Component
{
    public $title;
    public $event;
    public $filterActive;
    public $filterPresent;

    protected $listeners = [
        'booking-changed' => '$refresh'
    ];

    public function mount($title, $event, $filterActive = null, $filterPresent = null)
    {
        $this->title = $title;
        $this->event = $event;
        $this->filterActive = $filterActive;
        $this->filterPresent = $filterPresent;
    }

    public function markAsPresent($id)
    {
        Booking::find($id)->markAsPresent();

        $this->emit('booking-changed');
    }

    public function unmarkAsPresent($id)
    {
        Booking::find($id)->unmarkAsPresent();

        $this->emit('booking-changed');
    }

    public function render()
    {
        $visibleBookings = $this->event->bookings()->get()
            ->filter(fn($booking) => is_null($this->filterActive) || $this->filterActive == $booking->isActive())
            ->filter(fn($booking) => is_null($this->filterPresent) || $this->filterPresent == (boolean)$booking->present);

        return view('livewire.interactive-bookings', compact('visibleBookings'));
    }
}
