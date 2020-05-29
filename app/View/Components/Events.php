<?php

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Events extends Component
{
    public string $title;
    public Collection $events;

    /**
     * Create a new component instance.
     *
     * @param string $title
     * @param Collection $events
     */
    public function __construct(string $title, Collection $events)
    {
        $this->title = $title;
        $this->events = $events;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.events');
    }
}
