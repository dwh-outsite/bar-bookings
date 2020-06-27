<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class EventType extends Model
{
    use Sushi;

    protected array $rows = [
        [
            'id' => 'bar',
            'name' => 'Bar',
        ],
        [
            'id' => 'dinner',
            'name' => 'Dinner',
        ],
    ];

    public static function default() {
        return static::first();
    }
}
