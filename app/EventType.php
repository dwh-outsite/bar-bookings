<?php

namespace App;

use Illuminate\Support\Collection;

class EventType extends SushiModel
{
    protected $guarded = [];

    protected $casts = [
        'custom_fields' => 'array',
    ];

    protected array $rows = [
        [
            'id' => 'bar',
            'name' => 'Bar',
            'custom_fields' => [],
        ],
        [
            'id' => 'dinner',
            'name' => 'Dinner',
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
        ],
    ];

    public static function default()
    {
        return static::first();
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
