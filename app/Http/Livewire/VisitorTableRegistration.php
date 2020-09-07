<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VisitorTableRegistration extends Component
{
    public $booking;

    public function mount($booking)
    {
        $this->booking = $booking;

        if (request()->has('table')) {
            $this->addNewTablePlacement(request('table'));
        }
    }

    public function addNewTablePlacement($tableNumber)
    {
        $this->booking->tablePlacements()->create(['table_number' => $tableNumber]);

        $this->booking->refresh();

        session()->flash('message', 'Your new table has been registered. Thank you!');

        $this->emit('visitor-table-registered');
    }

    public function render()
    {
        return view('livewire.visitor.visitor-table-registration');
    }
}
