<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];

    protected $casts = [
        'is_online' => 'boolean',
        'is_active' => 'boolean',
        'archived' => 'boolean',
        'show_full_address' => 'boolean',
    ];

    public function scopeArchived($query)
    {
        return $query->where('archived', true);
    }

    public function scopeNotArchived($query)
    {
        return $query->where('archived', false);
    }

    public function landingPage(): HasOne
    {
        return $this->hasOne(EventLandingPage::class);
    }

    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user');
    }

    public function isOnline(): bool
    {
        return (bool) $this->is_online;
    }

    public function getVenueTypeLabel(): string
    {
        return $this->isOnline() ? 'Online' : 'On-site';
    }

    public function getVenueTypeBadgeClass(): string
    {
        return $this->isOnline() ? 'event-venue-badge--online' : 'event-venue-badge--onsite';
    }

    public function shouldShowAddress(): bool
    {
        return !$this->isOnline()
            && $this->show_full_address
            && filled($this->address);
    }

    public function getAddressLine(): ?string
    {
        return $this->shouldShowAddress() ? $this->address : null;
    }

    public function getCountryName(): ?string
    {
        $code = $this->country_code;

        return $code ? (config('countries.' . $code) ?? $code) : null;
    }

    public function getShareUrl(): string
    {
        if ($this->hasLandingPage()) {
            return $this->getLandingPageUrl();
        }

        return route('site.index', ['event' => $this->id]) . '#events';
    }

    public function hasLandingPage(): bool
    {
        $page = $this->relationLoaded('landingPage')
            ? $this->landingPage
            : $this->landingPage()->first();

        return $page && $page->is_enabled;
    }

    public function getLandingPageUrl(): string
    {
        return route('site.events.show', $this->slug);
    }

    public function heroSectionContent(): array
    {
        if (!$this->relationLoaded('landingPage')) {
            $this->load('landingPage.heroSection');
        }

        return $this->landingPage?->heroSection?->content ?? [];
    }

    public function aboutReasonsSectionContent(): array
    {
        if (!$this->relationLoaded('landingPage')) {
            $this->load('landingPage.aboutReasonsSection');
        }

        $section = $this->landingPage?->aboutReasonsSection;

        if (!$section || !$section->is_active) {
            return [];
        }

        return $section->content ?? [];
    }

    public function shouldShowAboutReasonsSection(): bool
    {
        $content = $this->aboutReasonsSectionContent();

        if (filled(data_get($content, 'about_title')) || filled(data_get($content, 'about_description'))) {
            return true;
        }

        foreach (data_get($content, 'reasons', []) as $reason) {
            if (filled(data_get($reason, 'title')) || filled(data_get($reason, 'description'))) {
                return true;
            }
        }

        return false;
    }

    public function getAboutReasonsCards(): array
    {
        $cards = data_get($this->aboutReasonsSectionContent(), 'reasons', []);

        return array_values(array_filter($cards, function ($card) {
            return filled(data_get($card, 'title')) || filled(data_get($card, 'description'));
        }));
    }

    public function statsSectionContent(): array
    {
        return $this->landingSectionContent('statsSection');
    }

    public function shouldShowStatsSection(): bool
    {
        foreach ($this->getStatsItems() as $stat) {
            if (filled(data_get($stat, 'value')) || filled(data_get($stat, 'label'))) {
                return true;
            }
        }

        return false;
    }

    public function getStatsItems(): array
    {
        $items = data_get($this->statsSectionContent(), 'stats', []);

        return array_values(array_filter($items, function ($item) {
            return filled(data_get($item, 'value')) || filled(data_get($item, 'label'));
        }));
    }

    public function detailsMapSectionContent(): array
    {
        return $this->landingSectionContent('detailsMapSection');
    }

    public function shouldShowDetailsMapSection(): bool
    {
        $content = $this->detailsMapSectionContent();

        if (filled(data_get($content, 'title'))
            || filled(data_get($content, 'description'))
            || $this->getDetailsMapEmbedSrc()) {
            return true;
        }

        return filled($this->getDetailsMapDate())
            || filled($this->getDetailsMapTime())
            || filled($this->getDetailsMapVenue())
            || filled($this->getDetailsMapAddress());
    }

    public function getDetailsMapLabel(): ?string
    {
        return data_get($this->detailsMapSectionContent(), 'label');
    }

    public function getDetailsMapTitle(): ?string
    {
        return data_get($this->detailsMapSectionContent(), 'title');
    }

    public function getDetailsMapDescription(): ?string
    {
        return data_get($this->detailsMapSectionContent(), 'description');
    }

    public function getDetailsMapDate(): ?string
    {
        return data_get($this->detailsMapSectionContent(), 'date') ?: $this->getLandingDateLabel();
    }

    public function getDetailsMapTime(): ?string
    {
        return data_get($this->detailsMapSectionContent(), 'time') ?: $this->getLandingTimeLabel();
    }

    public function getDetailsMapVenue(): ?string
    {
        return data_get($this->detailsMapSectionContent(), 'venue') ?: $this->getLandingLocationLabel();
    }

    public function getDetailsMapAddress(): ?string
    {
        if ($address = data_get($this->detailsMapSectionContent(), 'address')) {
            return $address;
        }

        return $this->getAddressLine();
    }

    public function getDetailsMapEmbedSrc(): ?string
    {
        $raw = trim((string) data_get($this->detailsMapSectionContent(), 'map_embed_url', ''));

        if ($raw === '') {
            if ($this->location && str_contains($this->location, 'google.com')) {
                return $this->location;
            }

            return null;
        }

        if (preg_match('/src=["\']([^"\']+)["\']/i', $raw, $matches)) {
            $raw = $matches[1];
        }

        if (!str_starts_with($raw, 'http')) {
            return null;
        }

        if (!str_contains($raw, 'google.com/maps')) {
            return null;
        }

        return $raw;
    }

    public static function landingAsset(?string $path): ?string
    {
        if (!filled($path)) {
            return null;
        }

        $path = trim(html_entity_decode((string) $path, ENT_QUOTES | ENT_HTML5, 'UTF-8'));

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (!str_starts_with($path, '/')) {
            $path = '/'.ltrim($path, '/');
        }

        $publicFile = public_path($path);
        if (is_file($publicFile)) {
            return asset($path);
        }

        if (app()->environment(['staging', 'production'])) {
            $uploadsRoot = rtrim((string) env('UPLOADS_FOLDER', ''), '/\\');
            if ($uploadsRoot !== '') {
                $externalFile = $uploadsRoot.$path;
                if (is_file($externalFile)) {
                    return asset($path);
                }
            }
        }

        return null;
    }

    public function speakersSectionContent(): array
    {
        return $this->landingSectionContent('speakersSection');
    }

    public function getSpeakersSectionLabel(): string
    {
        return data_get($this->speakersSectionContent(), 'section_label') ?: 'Meet our speakers';
    }

    public function getSpeakers(): array
    {
        $speakers = data_get($this->speakersSectionContent(), 'speakers', []);

        return array_values(array_filter($speakers, function ($speaker) {
            return filled(data_get($speaker, 'name'))
                || filled(data_get($speaker, 'photo'));
        }));
    }

    public function shouldShowSpeakersSection(): bool
    {
        return count($this->getSpeakers()) > 0;
    }

    public function agendaSectionContent(): array
    {
        return $this->landingSectionContent('agendaSection');
    }

    public function getAgendaSectionLabel(): string
    {
        return data_get($this->agendaSectionContent(), 'section_label') ?: 'Agenda';
    }

    public function getAgendaItems(): array
    {
        $items = data_get($this->agendaSectionContent(), 'items', []);

        return array_values(array_filter($items, function ($item) {
            return filled(data_get($item, 'time')) || filled(data_get($item, 'title'));
        }));
    }

    public function shouldShowAgendaSection(): bool
    {
        return count($this->getAgendaItems()) > 0;
    }

    public function partnersSectionContent(): array
    {
        return $this->landingSectionContent('partnersSection');
    }

    public function getPartnersSectionLabel(): string
    {
        return data_get($this->partnersSectionContent(), 'section_label') ?: 'Organizers & partners';
    }

    public function getPartners(): array
    {
        $partners = data_get($this->partnersSectionContent(), 'partners', []);

        return array_values(array_filter($partners, function ($partner) {
            return filled(data_get($partner, 'name')) || filled(data_get($partner, 'logo'));
        }));
    }

    public function shouldShowPartnersSection(): bool
    {
        return count($this->getPartners()) > 0;
    }

    public function organizersSectionContent(): array
    {
        return $this->landingSectionContent('organizersSection');
    }

    public function getOrganizersSectionLabel(): string
    {
        return data_get($this->organizersSectionContent(), 'section_label') ?: 'Organizers';
    }

    public function getOrganizersDescription(): ?string
    {
        return data_get($this->organizersSectionContent(), 'description');
    }

    public function getOrganizersLogoUrl(): string
    {
        return self::landingAsset(data_get($this->organizersSectionContent(), 'logo'))
            ?: asset('assets/logo.png');
    }

    public function getOrganizersBtnText(): string
    {
        return data_get($this->organizersSectionContent(), 'btn_text') ?: 'Learn more';
    }

    public function getOrganizersBtnUrl(): string
    {
        return data_get($this->organizersSectionContent(), 'btn_url')
            ?: 'https://www.nen-global.org/EN/index.html';
    }

    public function getOrganizersPartnerBtnText(): ?string
    {
        $text = data_get($this->organizersSectionContent(), 'partner_btn_text');

        return filled($text) ? $text : null;
    }

    public function getOrganizersPartnerBtnUrl(): ?string
    {
        $url = data_get($this->organizersSectionContent(), 'partner_btn_url');

        return filled($url) ? $url : null;
    }

    public function getOrganizersNetworkStats(): array
    {
        $stats = data_get($this->organizersSectionContent(), 'network_stats', []);

        return array_values(array_filter($stats, function ($stat) {
            return filled(data_get($stat, 'title')) || filled(data_get($stat, 'value'));
        }));
    }

    public function shouldShowOrganizersSection(): bool
    {
        if (filled($this->getOrganizersDescription())) {
            return true;
        }

        if (filled($this->getOrganizersBtnText()) && filled(data_get($this->organizersSectionContent(), 'btn_url'))) {
            return true;
        }

        if (filled($this->getOrganizersPartnerBtnText()) && filled($this->getOrganizersPartnerBtnUrl())) {
            return true;
        }

        if (!$this->usesAllOrganizersMapLocations() && count($this->getOrganizersMapLocationIds()) > 0) {
            return true;
        }

        return count($this->getOrganizersNetworkStats()) > 0;
    }

    public function usesAllOrganizersMapLocations(): bool
    {
        return data_get($this->organizersSectionContent(), 'map_location_ids') === null;
    }

    public function getOrganizersMapLocationIds(): array
    {
        $ids = data_get($this->organizersSectionContent(), 'map_location_ids');

        if ($ids === null) {
            return [];
        }

        return array_values(array_filter(array_map('intval', (array) $ids)));
    }

    public function landingFaqSectionContent(): array
    {
        return $this->landingSectionContent('landingFaqSection');
    }

    public function getLandingFaqSectionLabel(): string
    {
        return data_get($this->landingFaqSectionContent(), 'section_label') ?: 'Frequently asked questions';
    }

    public function getLandingFaqItems(): array
    {
        $items = data_get($this->landingFaqSectionContent(), 'items', []);

        return array_values(array_filter($items, function ($item) {
            return filled(data_get($item, 'question'));
        }));
    }

    public function shouldShowLandingFaqSection(): bool
    {
        return count($this->getLandingFaqItems()) > 0;
    }

    public function mediaSectionContent(): array
    {
        return $this->landingSectionContent('mediaSection');
    }

    public function getMediaSectionLabel(): string
    {
        return data_get($this->mediaSectionContent(), 'section_label') ?: 'Media';
    }

    public function getMediaItems(): array
    {
        $items = data_get($this->mediaSectionContent(), 'items', []);

        return array_values(array_filter($items, function ($item) {
            if (data_get($item, 'type') === 'video') {
                return filled(data_get($item, 'url'));
            }

            return filled(data_get($item, 'file'));
        }));
    }

    public function shouldShowMediaSection(): bool
    {
        return count($this->getMediaItems()) > 0;
    }

    public static function landingMediaYoutubeEmbed(?string $url): ?string
    {
        if (!filled($url)) {
            return null;
        }

        $url = trim($url);

        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1] . '?rel=0';
        }

        if (str_contains($url, 'youtube.com/embed/')) {
            return $url;
        }

        return null;
    }

    protected function landingSectionContent(string $relation): array
    {
        if (!$this->relationLoaded('landingPage')) {
            $this->load('landingPage.' . $relation);
        }

        $section = $this->landingPage?->{$relation};

        if (!$section || !$section->is_active) {
            return [];
        }

        return $section->content ?? [];
    }

    protected function hero(string $key, mixed $default = null): mixed
    {
        $value = data_get($this->heroSectionContent(), $key);

        return filled($value) ? $value : $default;
    }

    public function getLandingHeroImage(): string
    {
        $path = $this->hero('hero_image');

        return $path ? asset($path) : $this->getImage();
    }

    public function getLandingQrImage(): ?string
    {
        $path = $this->hero('qr_image');

        return $path ? asset($path) : null;
    }

    public function getLandingTitle(): string
    {
        return $this->hero('title') ?? $this->name;
    }

    public function getLandingTitleHighlight(): ?string
    {
        return $this->hero('title_highlight');
    }

    public function getLandingDescription(): ?string
    {
        return $this->hero('description') ?? $this->description;
    }

    public function getLandingDateLabel(): ?string
    {
        if ($label = $this->hero('date_label')) {
            return $label;
        }

        if (!$this->date) {
            return null;
        }

        return \Carbon\Carbon::parse($this->date)->format('j F Y, l');
    }

    public function getLandingTimeLabel(): ?string
    {
        return $this->hero('time_label') ?? $this->time;
    }

    public function getLandingLocationLabel(): ?string
    {
        if ($label = $this->hero('location_label')) {
            return $label;
        }

        if ($this->isOnline()) {
            return 'Online';
        }

        $parts = array_filter([
            $this->getAddressLine(),
            $this->getCountryName(),
        ]);

        if ($parts) {
            return implode(', ', $parts);
        }

        return $this->location ?: $this->address;
    }

    public function getLandingRegisterLabel(): string
    {
        return $this->hero('register_label') ?? 'Register now';
    }

    public function getLandingAgendaLabel(): string
    {
        return $this->hero('agenda_label') ?? 'View agenda';
    }

    public function getLandingAgendaUrl(): ?string
    {
        if ($url = $this->hero('agenda_url')) {
            return $url;
        }

        return $this->pdf ? asset($this->pdf) : null;
    }

    public function getLandingCountdownIso(): ?string
    {
        $raw = $this->hero('countdown_at');

        if ($raw) {
            return \Carbon\Carbon::parse($raw)->toIso8601String();
        }

        if ($this->date) {
            return \Carbon\Carbon::parse($this->date)->startOfDay()->toIso8601String();
        }

        return null;
    }

    public function getLandingCountdownEndIso(): ?string
    {
        $raw = $this->hero('countdown_end_at');

        if ($raw) {
            return \Carbon\Carbon::parse($raw)->toIso8601String();
        }

        $timeLabel = $this->getLandingTimeLabel();
        if ($timeLabel && preg_match('/-\s*(\d{1,2}:\d{2})/', $timeLabel, $matches)) {
            $dateSource = $this->hero('countdown_at') ?: $this->date;
            if ($dateSource) {
                $date = \Carbon\Carbon::parse($dateSource)->toDateString();

                return \Carbon\Carbon::parse($date.' '.$matches[1])->toIso8601String();
            }
        }

        $startIso = $this->getLandingCountdownIso();
        if ($startIso) {
            return \Carbon\Carbon::parse($startIso)->addHours(5)->toIso8601String();
        }

        return null;
    }

    public function getLandingWhatsappUrl(): ?string
    {
        return $this->hero('whatsapp_url');
    }

    public function getLandingTelegramUrl(): ?string
    {
        return $this->hero('telegram_url');
    }

    public function getLandingFaqUrl(): ?string
    {
        return $this->hero('faq_url');
    }

    public function getLandingGoogleCalendarUrl(): ?string
    {
        $startIso = $this->getLandingCountdownIso();
        if (!$startIso) {
            return null;
        }

        $timezone = config('app.timezone', 'UTC');
        $start = \Carbon\Carbon::parse($startIso)->timezone($timezone);

        $timeLabel = $this->getLandingTimeLabel();
        if (!$this->hero('countdown_at') && $timeLabel && preg_match('/(\d{1,2}:\d{2})\s*-/', $timeLabel, $startMatch)) {
            $start = \Carbon\Carbon::parse($start->toDateString().' '.$startMatch[1])->timezone($timezone);
        }

        $endIso = $this->getLandingCountdownEndIso();
        $end = $endIso
            ? \Carbon\Carbon::parse($endIso)->timezone($timezone)
            : $start->copy()->addHour();

        if ($end->lte($start)) {
            $end = $start->copy()->addHour();
        }

        $title = trim(strip_tags(str_replace(["\r\n", "\r", "\n"], ' ', $this->getLandingTitle())));
        if ($highlight = $this->getLandingTitleHighlight()) {
            $title = trim($title.' '.$highlight);
        }

        $details = [];
        if ($description = $this->getLandingDescription()) {
            $details[] = strip_tags($description);
        }
        $details[] = $this->getLandingPageUrl();

        $params = [
            'action' => 'TEMPLATE',
            'text' => $title,
            'dates' => $start->format('Ymd\THis').'/'.$end->format('Ymd\THis'),
            'ctz' => $timezone,
            'details' => implode("\n\n", array_filter($details)),
        ];

        if ($location = $this->getLandingLocationLabel()) {
            $params['location'] = $location;
        }

        return 'https://calendar.google.com/calendar/render?'.http_build_query(
            $params,
            '',
            '&',
            PHP_QUERY_RFC3986
        );
    }
}
