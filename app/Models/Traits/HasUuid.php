<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Boot function from Laravel.
     * Generates a UUID for the primary key if it's not set.
     */
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Indicates if the model's ID is incrementing.
     * MUST be set to false for UUIDs.
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Get the primary key type.
     * MUST be set to 'string' for UUIDs.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }
}