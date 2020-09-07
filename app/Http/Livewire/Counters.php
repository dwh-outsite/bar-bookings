<?php

namespace App\Http\Livewire;

use App\Http\Middleware\BarAuthentication;
use Livewire\Component;

class Counters extends Component
{
    public $event;

    protected $listeners = [
        'booking-changed' => '$refresh'
    ];

    public function hydrate()
    {
        BarAuthentication::authenticate(request());
    }

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
