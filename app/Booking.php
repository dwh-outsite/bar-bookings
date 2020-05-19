<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Booking extends Model
{
    protected $guarded = [];
    protected $with = ['event'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function scopeEndDateInTheFuture(Builder $query)
    {
        $query->whereHas('event', function (Builder $query) {
            $query->where('end', '>', Carbon::now());
        });
    }
}
