<?php

namespace App;

use App\View\Widgets\DinnerStatistics;

class EventType extends SushiModel
{
    protected $guarded = [];

    protected $keyType = 'string';

    protected $casts = [
        'custom_fields' => 'array',
    ];

    protected array $rows = [
        [
            'id' => 'bar',
            'name' => 'Bar',
            'widget' => null,
            'custom_fields' => [],
            'single_booking' => true,
        ],
        [
            'id' => 'dinner',
            'name' => 'Dinner',
            'widget' => DinnerStatistics::class,
            'custom_fields' => [
                'team' => [
                    'type' => 'string',
                    'validation' => 'required|string',
                ],
                'diet' => [
                    'type' => 'array',
                    'validation' => 'array',
                ],
            ],
            'single_booking' => true,
        ],
        [
            'id' => 'worqspaces',
            'name' => 'Worqspaces',
            'widget' => null,
            'custom_fields' => [],
            'single_booking' => false,
        ],
        [
            'id' => 'other',
            'name' => 'Other',
            'widget' => null,
            'custom_fields' => [],
            'single_booking' => true,
        ],
    ];

    public static function default()
    {
        return static::first();
    }

    public function hasWidget()
    {
        return !is_null($this->widget);
    }

    public function widget($event)
    {
        return new $this->widget($event);
    }

    public function customFieldNames()
    {
        return collect($this->custom_fields)->map(fn ($field, $name) => $name);
    }

    public function customFieldsValidationRules($prefix)
    {
        $generalRule = [
            'array',
            function ($attribute, $value, $fail) {
                tap(
                    collect($value)->keys()->diff($this->customFieldNames()),
                    fn ($mismatch) => $mismatch->isNotEmpty() ? $fail('The following custom fields are not allowed: ' . $mismatch->implode(', ')) : null
                );
            }
        ];

        return collect($this->custom_fields)
            ->mapWithKeys(fn($field, $name) => [$prefix.'.'.$name => $field['validation']])
            ->put($prefix, $generalRule)
            ->all();
    }
}
