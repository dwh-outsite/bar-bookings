<?php

namespace App\View\Components;

use Illuminate\View\Component;

class HealthCheckRule extends Component
{
    public $number;

    public function __construct($number)
    {
        $this->number = $number;
    }

    public function render()
    {
        return view('components.health-check-rule');
    }
}
