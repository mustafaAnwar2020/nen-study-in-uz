<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class NenLandingMediaItem extends Model
{
    use ModelsCommonTrait;

    public const SLOT_LEFT_TOP = 'left_top';
    public const SLOT_LEFT_BOTTOM = 'left_bottom';
    public const SLOT_CENTER = 'center';
    public const SLOT_RIGHT_TOP = 'right_top';
    public const SLOT_RIGHT_BOTTOM = 'right_bottom';

    public static function layoutSlots(): array
    {
        return [
            self::SLOT_LEFT_TOP => 'Left top',
            self::SLOT_LEFT_BOTTOM => 'Left bottom',
            self::SLOT_CENTER => 'Center (featured)',
            self::SLOT_RIGHT_TOP => 'Right top',
            self::SLOT_RIGHT_BOTTOM => 'Right bottom',
        ];
    }

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
