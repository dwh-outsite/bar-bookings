<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class SushiModel extends Model
{
    use Sushi;

    /**
     * Override original migrate method to support JSON fields.
     */
    public function migrate()
    {
        $rows = $this->getRows();
        $firstRow = $rows[0];
        $tableName = $this->getTable();

        static::resolveConnection()->getSchemaBuilder()->create($tableName, function ($table) use ($firstRow) {
            // Add the "id" column if it doesn't already exist in the rows.
            if ($this->incrementing && !in_array($this->primaryKey, array_keys($firstRow))) {
                $table->increments($this->primaryKey);
            }

            foreach ($firstRow as $column => $value) {
                switch (true) {
                    case is_int($value):
                        $type = 'integer';
                        break;
                    case is_numeric($value):
                        $type = 'float';
                        break;
                    case is_string($value):
                        $type = 'string';
                        break;
                    case is_object($value) && $value instanceof \DateTime:
                        $type = 'dateTime';
                        break;
                    default:
                        $type = 'string';
                }

                if ($column === $this->primaryKey && $type == 'integer') {
                    $table->increments($this->primaryKey);
                    continue;
                }

                $schema = $this->getSchema();

                $type = $schema[$column] ?? $type;

                $table->{$type}($column)->nullable();
            }

            if ($this->usesTimestamps() && (!in_array('updated_at', array_keys($firstRow)) || !in_array('created_at', array_keys($firstRow)))) {
                $table->timestamps();
            }
        });

        foreach ($rows as $row) {
            static::create($row);
        }
    }
}
