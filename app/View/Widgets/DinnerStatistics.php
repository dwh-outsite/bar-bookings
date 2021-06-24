<?php

namespace App\View\Widgets;

class DinnerStatistics {
    private $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function diets()
    {
        return $this->event->bookings
            ->filter->isActive()
            ->filter->hasCustomFields()
            ->map->custom_fields
            ->map->diet
            ->flatten()
            ->countBy();
    }

    public function teams()
    {
        return $this->event->bookings
            ->filter->isActive()
            ->filter->hasCustomFields()
            ->map->custom_fields
            ->map->team
            ->flatten()
            ->countBy();
    }

    public function render()
    {
        return view('widgets.dinner-statistics', [
            'diets' => $this->diets(),
            'teams' => $this->teams(),
        ]);
    }
}
