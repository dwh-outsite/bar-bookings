<?php

namespace App\Http\Livewire;

use Livewire\Castable;

class BooleanCaster implements Castable
{
    public function cast($value)
    {
        return $value == 'true';
    }

    public function uncast($value)
    {
        return $value ? 'true' : 'false';
    }
}
