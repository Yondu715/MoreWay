<?php

namespace App\Infrastructure\Database\Models\Traits;

// Test trait
trait HasFormattedTimestamps
{
    /**
     * @return string
     */
    public function getCreatedAtAttribute(): string
    {
        return $this->created_at->format('Y-m-d H:i:s');
    }

    /**
     * @return string
     */
    public function getUpdatedAtAttribute(): string
    {
        return $this->updated_at->format('Y-m-d H:i:s');
    }

    /**
     * @return string
     */
    public function getDeletedAtAttribute(): string
    {
        return $this->deleted_at->format('Y-m-d H:i:s');
    }
}
