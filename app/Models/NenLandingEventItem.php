<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class NenLandingEventItem extends Model
{
    use ModelsCommonTrait;

    public const TYPE_HIGHLIGHT = 'highlight';
    public const TYPE_ARCHIVE = 'archive';

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'event_date' => 'date',
    ];
}
