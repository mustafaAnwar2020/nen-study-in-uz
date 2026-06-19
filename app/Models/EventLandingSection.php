<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventLandingSection extends Model
{
    public const TYPE_HERO = 'hero';

    public const TYPE_ABOUT_REASONS = 'about_reasons';

    public const TYPE_STATS = 'stats';

    public const TYPE_DETAILS_MAP = 'details_map';

    public const TYPE_SPEAKERS = 'speakers';

    public const TYPE_AGENDA = 'agenda';

    public const TYPE_PARTNERS = 'partners';

    public const TYPE_ORGANIZERS = 'organizers';

    public const TYPE_MEDIA = 'media';

    public const TYPE_LANDING_FAQ = 'landing_faq';

    protected $guarded = [];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
    ];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(EventLandingPage::class, 'event_landing_page_id');
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return data_get($this->content, $key, $default);
    }
}
