<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VisitorEnterCodeForm extends Component
{
    public $visitor_code;

    public function submit()
    {
        $this->visitor_code = strtoupper($this->visitor_code);

        $this->validate([
            'visitor_code' => ['required', 'size:6', 'string', 'exists:App\Booking,visitor_code']
        ]);

        return redirect(route('visitor').'?visitor_code='.$this->visitor_code);
    }

    public function render()
    {
        return view('livewire.visitor.visitor-enter-code-form');
    }
}
