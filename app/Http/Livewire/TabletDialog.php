<?php

namespace App\Http\Livewire;

use App\Events\PersonalInformationEnteredOnTablet;
use App\Http\Middleware\BarAuthentication;
use Livewire\Component;

class TabletDialog extends Component
{
    public $state = 'inactive';

    public $email;
    public $phone_number;

    public function hydrate()
    {
        BarAuthentication::authenticate(request());
    }

    public function confirm()
    {
        $this->validate([
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['required', 'string'],
        ]);

        event(new PersonalInformationEnteredOnTablet($this->email, $this->phone_number));

        $this->close();
    }

    public function close()
    {
        $this->state = 'inactive';

        $this->reset();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.tablet-dialog');
    }
}
