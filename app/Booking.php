<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];
    protected $with = ['event'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
