<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RegisterNewGuestButton extends Component
{
    public function register()
    {
        $this->emit('new-guest');
    }

    public function render()
    {
        return view('livewire.register-new-guest-button');
    }
}
