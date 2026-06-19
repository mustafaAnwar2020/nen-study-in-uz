<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EventLandingPage extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(EventLandingSection::class)->orderBy('sort_order');
    }

    public function heroSection(): HasOne
    {
        return $this->hasOne(EventLandingSection::class)
            ->where('type', EventLandingSection::TYPE_HERO);
    }

    public function aboutReasonsSection(): HasOne
    {
        return $this->hasOne(EventLandingSection::class)
            ->where('type', EventLandingSection::TYPE_ABOUT_REASONS);
    }

    public function statsSection(): HasOne
    {
        return $this->hasOne(EventLandingSection::class)
            ->where('type', EventLandingSection::TYPE_STATS);
    }

    public function detailsMapSection(): HasOne
    {
        return $this->hasOne(EventLandingSection::class)
            ->where('type', EventLandingSection::TYPE_DETAILS_MAP);
    }

    public function speakersSection(): HasOne
    {
        return $this->hasOne(EventLandingSection::class)
            ->where('type', EventLandingSection::TYPE_SPEAKERS);
    }

    public function agendaSection(): HasOne
    {
        return $this->hasOne(EventLandingSection::class)
            ->where('type', EventLandingSection::TYPE_AGENDA);
    }

    public function partnersSection(): HasOne
    {
        return $this->hasOne(EventLandingSection::class)
            ->where('type', EventLandingSection::TYPE_PARTNERS);
    }

    public function organizersSection(): HasOne
    {
        return $this->hasOne(EventLandingSection::class)
            ->where('type', EventLandingSection::TYPE_ORGANIZERS);
    }

    public function mediaSection(): HasOne
    {
        return $this->hasOne(EventLandingSection::class)
            ->where('type', EventLandingSection::TYPE_MEDIA);
    }

    public function landingFaqSection(): HasOne
    {
        return $this->hasOne(EventLandingSection::class)
            ->where('type', EventLandingSection::TYPE_LANDING_FAQ);
    }

    public function activeSections(): HasMany
    {
        return $this->sections()->where('is_active', true);
    }
}
