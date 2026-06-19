<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRequest extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_done' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function getStatus(): string
    {
        return $this->is_done ? 'Handled' : 'New';
    }
}
