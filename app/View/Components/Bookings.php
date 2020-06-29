<?php

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Bookings extends Component
{
    public string $title;
    public Collection $bookings;
    public bool $readOnly;

    /**
     * Create a new component instance.
     *
     * @param string $title
     * @param Collection $bookings
     * @param bool $readOnly
     */
    public function __construct(string $title, Collection $bookings, bool $readOnly = false)
    {
        $this->title = $title;
        $this->bookings = $bookings;
        $this->readOnly = $readOnly;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.bookings');
    }
}
