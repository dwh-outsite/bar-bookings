<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counters extends Component
{
    public $event;

    protected $listeners = [
        'booking-changed' => '$refresh'
    ];

    public function mount($event)
    {
        $this->event = $event;
    }

    public function render()
    {
        $this->event->refresh();

        return view('livewire.counters');
    }
}
