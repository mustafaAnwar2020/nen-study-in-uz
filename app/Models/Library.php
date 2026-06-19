<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];

    public const TYPES = [
        'resource' => 'Resource',
        'useful-links' => 'Useful Links',
        'news' => 'News',
    ];


}
