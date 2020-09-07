<?php

namespace App\Http\Livewire;

use App\Http\Middleware\BarAuthentication;
use Livewire\Component;

class RegisterNewGuestButton extends Component
{
    public function hydrate()
    {
        BarAuthentication::authenticate(request());
    }

    public function register()
    {
        $this->emit('new-guest');
    }

    public function render()
    {
        return view('livewire.register-new-guest-button');
    }
}
