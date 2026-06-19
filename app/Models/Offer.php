<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];

    protected $casts = [
        'use_book_now' => 'boolean',
    ];

    /**
     * Country-specific Book Now links (stored as JSON: [{"country":"ae","url":"..."}, ...]).
     */
    public function getBookNowUrl(): array
    {
        if (!$this->book_now_by_country) {
            return [];
        }

        $decoded = json_decode($this->book_now_by_country);

        return is_array($decoded) ? $decoded : [];
    }

    public function hasConfiguredMoreDetails(): bool
    {
        return trim((string)$this->more_details_text) !== ''
            && trim((string)$this->more_details_url) !== '';
    }

    public function getStatus()
    {
        switch ($this->status) {
            case 'new':
                return '<span class="badge badge-primary">جديد</span>';
            case 'in_progress':
                return '<span class="badge badge-warning">جار العمل</span>';
            case 'done':
                return '<span class="badge badge-success">منتهي</span>';
            default:
                return '<span class="badge badge-secondary">جديد</span>';
        }
    }


}
