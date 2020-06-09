<?php

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Events extends Component
{
    public string $title;
    public Collection $events;
    public string $area;

    /**
     * Create a new component instance.
     *
     * @param string $title
     * @param Collection $events
     * @param string $area
     */
    public function __construct(string $title, Collection $events, $area = 'admin')
    {
        $this->title = $title;
        $this->events = $events;
        $this->area = $area;
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
