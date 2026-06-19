<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];

    public const TYPES = [
        'TOEFL-IBT'            => 'TOEFL IBT',
        'TOEFL-ITP'            => 'TOEFL ITP',
        'TOEIC'                => 'TOEIC',
        'GRE'                  => 'GRE',
        'TOEFL-Young-Students' => 'TOEFL Young Students',
        'GENERAL'              => 'General',
    ];

    public const TYPESEXCEPTGENERAL = [
        'TOEFL-IBT'            => 'TOEFL IBT',
        'TOEFL-ITP'            => 'TOEFL ITP',
        'TOEIC'                => 'TOEIC',
        'GRE'                  => 'GRE',
        'TOEFL-Young-Students' => 'TOEFL Young Students',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function getBookNowUrl()
    {
        return $this->book_now_url ? json_decode($this->book_now_url) : [];
    }

    public function section()
    {
        return $this->hasOne(Section::class);
    }


}
