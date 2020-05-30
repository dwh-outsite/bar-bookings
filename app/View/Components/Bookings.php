<?php

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Bookings extends Component
{
    public string $title;
    public Collection $bookings;

    /**
     * Create a new component instance.
     *
     * @param string $title
     * @param Collection $bookings
     */
    public function __construct(string $title, Collection $bookings)
    {
        $this->title = $title;
        $this->bookings = $bookings;
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
