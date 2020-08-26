<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InteractiveBookings extends Component
{
    public $title;
    public $event;
    public $filterActive;
    public $filterPresent;
    public $filterLeft;

    protected $listeners = [
        'booking-changed' => '$refresh'
    ];

    public function mount($title, $event, $filterActive = null, $filterPresent = null, $filterLeft = null)
    {
        $this->title = $title;
        $this->event = $event;
        $this->filterActive = $filterActive;
        $this->filterPresent = $filterPresent;
        $this->filterLeft = $filterLeft;
    }

    public function markAsPresent($id)
    {
        $this->emit('booking-present', $id);
    }

    public function change($id)
    {
        $this->emit('booking-change', $id);
    }

    public function render()
    {
        $visibleBookings = $this->event->bookings()->get()
            ->filter(fn($booking) => is_null($this->filterActive) || $this->filterActive == $booking->isActive())
            ->filter(fn($booking) => is_null($this->filterPresent) || $this->filterPresent == (boolean)$booking->present)
            ->filter(fn($booking) => is_null($this->filterLeft) || $this->filterLeft == (boolean)$booking->left);

        return view('livewire.interactive-bookings', compact('visibleBookings'));
    }
}
