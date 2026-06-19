<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class NenLandingAgency extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public const TYPE_TRANSLATION = 'translation';
    public const TYPE_TRUSTED = 'trusted';

    public static function types(): array
    {
        return [
            self::TYPE_TRANSLATION => 'Certified Translation Agency',
            self::TYPE_TRUSTED     => 'Trusted Study Abroad Agency',
        ];
    }
}
