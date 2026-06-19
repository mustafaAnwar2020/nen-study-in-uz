<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventLandingSection;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;

class EventLandingPageService
{
    use CommonTrait;

    public const SPEAKER_SLOTS = 8;

    public const AGENDA_SLOTS = 8;

    public const PARTNER_SLOTS = 10;

    public const FAQ_SLOTS = 8;

    public const MEDIA_SLOTS = 12;

    public const ORGANIZERS_NETWORK_STAT_SLOTS = 5;

    private const ORGANIZERS_TEXT_FIELDS = [
        'landing_organizers_label' => 'section_label',
        'landing_organizers_description' => 'description',
        'landing_organizers_btn_text' => 'btn_text',
        'landing_organizers_btn_url' => 'btn_url',
        'landing_organizers_partner_btn_text' => 'partner_btn_text',
        'landing_organizers_partner_btn_url' => 'partner_btn_url',
    ];

    private const HERO_TEXT_FIELDS = [
        'landing_title' => 'title',
        'landing_title_highlight' => 'title_highlight',
        'landing_description' => 'description',
        'landing_date_label' => 'date_label',
        'landing_time_label' => 'time_label',
        'landing_location_label' => 'location_label',
        'landing_register_label' => 'register_label',
        'landing_agenda_label' => 'agenda_label',
        'landing_whatsapp_url' => 'whatsapp_url',
        'landing_telegram_url' => 'telegram_url',
        'landing_faq_url' => 'faq_url',
    ];

    private const ABOUT_REASONS_TEXT_FIELDS = [
        'landing_about_label' => 'about_label',
        'landing_about_title' => 'about_title',
        'landing_about_description' => 'about_description',
        'landing_reasons_label' => 'reasons_label',
        'landing_reasons_title' => 'reasons_title',
        'landing_reasons_desc' => 'reasons_desc',
    ];

    private const DETAILS_MAP_TEXT_FIELDS = [
        'landing_details_label' => 'label',
        'landing_details_title' => 'title',
        'landing_details_description' => 'description',
        'landing_details_date' => 'date',
        'landing_details_time' => 'time',
        'landing_details_venue' => 'venue',
        'landing_details_address' => 'address',
        'landing_details_map_embed_url' => 'map_embed_url',
    ];

    public function sync(Event $event, Request $request): void
    {
        $enabled = $request->boolean('has_landing_page');
        $landingPage = $event->landingPage;

        if (!$enabled && !$landingPage && !$this->requestHasLandingPayload($request)) {
            return;
        }

        $landingPage = $event->landingPage()->firstOrCreate([]);
        $landingPage->update(['is_enabled' => $enabled]);

        $this->syncHeroSection($landingPage, $request);
        $this->syncAboutReasonsSection($landingPage, $request);
        $this->syncStatsSection($landingPage, $request);
        $this->syncDetailsMapSection($landingPage, $request);
        $this->syncSpeakersSection($landingPage, $request);
        $this->syncAgendaSection($landingPage, $request);
        $this->syncOrganizersSection($landingPage, $request);
        $this->syncPartnersSection($landingPage, $request);
        $this->syncLandingFaqSection($landingPage, $request);
        $this->syncMediaSection($landingPage, $request);
    }

    public static function extraValidationRules(): array
    {
        $rules = [
            'landing_speakers_label' => 'nullable|string|max:255',
            'landing_agenda_section_label' => 'nullable|string|max:255',
            'landing_partners_label' => 'nullable|string|max:255',
            'landing_organizers_label' => 'nullable|string|max:255',
            'landing_organizers_description' => 'nullable|string',
            'landing_organizers_btn_text' => 'nullable|string|max:255',
            'landing_organizers_btn_url' => 'nullable|string|max:2048',
            'landing_organizers_partner_btn_text' => 'nullable|string|max:255',
            'landing_organizers_partner_btn_url' => 'nullable|string|max:2048',
            'landing_organizers_logo' => 'nullable|string|max:2048',
            'landing_organizers_map_use_all' => 'nullable|boolean',
            'landing_organizers_map_location_ids' => 'nullable|array',
            'landing_organizers_map_location_ids.*' => 'integer|exists:locations,id',
            'landing_faq_section_label' => 'nullable|string|max:255',
            'landing_reasons_title' => 'nullable|string|max:255',
            'landing_reasons_desc' => 'nullable|string',
            'landing_about_images_main' => 'nullable|string|max:2048',
            'landing_about_images_secondary' => 'nullable|string|max:2048',
            'landing_speakers_json' => 'nullable|json',
            'landing_agenda_json' => 'nullable|json',
            'landing_partners_json' => 'nullable|json',
            'landing_faq_json' => 'nullable|json',
            'landing_media_section_label' => 'nullable|string|max:255',
            'landing_media_json' => 'nullable|json',
        ];

        for ($i = 1; $i <= self::FAQ_SLOTS; $i++) {
            $rules["landing_faq_{$i}_question"] = 'nullable|string|max:500';
            $rules["landing_faq_{$i}_answer"] = 'nullable|string';
        }

        for ($i = 1; $i <= self::SPEAKER_SLOTS; $i++) {
            $rules["landing_speaker_{$i}_name"] = 'nullable|string|max:255';
            $rules["landing_speaker_{$i}_title"] = 'nullable|string|max:255';
            $rules["landing_speaker_{$i}_organization"] = 'nullable|string|max:255';
            $rules["landing_speaker_{$i}_photo"] = 'nullable|string|max:2048';
            $rules["landing_speaker_{$i}_org_logo"] = 'nullable|string|max:2048';
        }

        for ($i = 1; $i <= self::AGENDA_SLOTS; $i++) {
            $rules["landing_agenda_{$i}_time"] = 'nullable|string|max:64';
            $rules["landing_agenda_{$i}_title"] = 'nullable|string|max:255';
            $rules["landing_agenda_{$i}_icon"] = 'nullable|string|max:64';
        }

        for ($i = 1; $i <= self::PARTNER_SLOTS; $i++) {
            $rules["landing_partner_{$i}_name"] = 'nullable|string|max:255';
            $rules["landing_partner_{$i}_logo"] = 'nullable|string|max:2048';
        }

        for ($i = 0; $i < self::MEDIA_SLOTS; $i++) {
            $rules["landing_media_{$i}_file"] = 'nullable|string|max:2048';
        }

        for ($i = 1; $i <= self::ORGANIZERS_NETWORK_STAT_SLOTS; $i++) {
            $rules["landing_organizers_stat_{$i}_title"] = 'nullable|string|max:255';
            $rules["landing_organizers_stat_{$i}_value"] = 'nullable|string|max:64';
            $rules["landing_organizers_stat_{$i}_icon"] = 'nullable|string|max:64';
            $rules["landing_organizers_stat_{$i}_image"] = 'nullable|string|max:2048';
        }

        return $rules;
    }

    public static function fieldsToUnsetFromEventData(): array
    {
        return array_keys(self::extraValidationRules());
    }

    private function syncHeroSection($landingPage, Request $request): void
    {
        $existing = $landingPage->heroSection?->content ?? [];
        $content = $this->buildHeroContent($existing, $request);

        $landingPage->sections()->updateOrCreate(
            ['type' => EventLandingSection::TYPE_HERO],
            ['content' => $content, 'sort_order' => 0, 'is_active' => true]
        );
    }

    private function syncAboutReasonsSection($landingPage, Request $request): void
    {
        $existing = $landingPage->aboutReasonsSection?->content ?? [];
        $content = $this->buildAboutReasonsContent($existing, $request);

        $landingPage->sections()->updateOrCreate(
            ['type' => EventLandingSection::TYPE_ABOUT_REASONS],
            ['content' => $content, 'sort_order' => 10, 'is_active' => true]
        );
    }

    private function syncStatsSection($landingPage, Request $request): void
    {
        $existing = $landingPage->statsSection?->content ?? [];
        $content = $this->buildStatsContent($existing, $request);

        $landingPage->sections()->updateOrCreate(
            ['type' => EventLandingSection::TYPE_STATS],
            ['content' => $content, 'sort_order' => 20, 'is_active' => true]
        );
    }

    private function syncDetailsMapSection($landingPage, Request $request): void
    {
        $existing = $landingPage->detailsMapSection?->content ?? [];
        $content = $this->buildDetailsMapContent($existing, $request);

        $landingPage->sections()->updateOrCreate(
            ['type' => EventLandingSection::TYPE_DETAILS_MAP],
            ['content' => $content, 'sort_order' => 30, 'is_active' => true]
        );
    }

    private function requestHasLandingPayload(Request $request): bool
    {
        foreach (array_keys(self::HERO_TEXT_FIELDS) as $field) {
            if ($request->filled($field)) {
                return true;
            }
        }

        foreach (array_keys(self::ABOUT_REASONS_TEXT_FIELDS) as $field) {
            if ($request->filled($field)) {
                return true;
            }
        }

        foreach (array_keys(self::DETAILS_MAP_TEXT_FIELDS) as $field) {
            if ($request->filled($field)) {
                return true;
            }
        }

        for ($i = 1; $i <= 3; $i++) {
            if ($request->filled("landing_reason_{$i}_title")
                || $request->filled("landing_reason_{$i}_description")) {
                return true;
            }
        }

        for ($i = 1; $i <= 4; $i++) {
            if ($request->filled("landing_stat_{$i}_value")
                || $request->filled("landing_stat_{$i}_label")) {
                return true;
            }
        }

        // Dynamic JSON inputs
        if ($request->filled('landing_speakers_json')
            || $request->filled('landing_agenda_json')
            || $request->filled('landing_partners_json')
            || $request->filled('landing_faq_json')) {
            return true;
        }

        // Legacy fixed-slot checks
        if ($request->filled('landing_speakers_label') || $request->filled('landing_agenda_section_label') || $request->filled('landing_partners_label')) {
            return true;
        }

        for ($i = 1; $i <= self::SPEAKER_SLOTS; $i++) {
            if ($request->filled("landing_speaker_{$i}_name") || $request->filled("landing_speaker_{$i}_photo")) {
                return true;
            }
        }

        for ($i = 1; $i <= self::AGENDA_SLOTS; $i++) {
            if ($request->filled("landing_agenda_{$i}_time") || $request->filled("landing_agenda_{$i}_title")) {
                return true;
            }
        }

        for ($i = 1; $i <= self::PARTNER_SLOTS; $i++) {
            if ($request->filled("landing_partner_{$i}_name") || $request->filled("landing_partner_{$i}_logo")) {
                return true;
            }
        }

        foreach (array_keys(self::ORGANIZERS_TEXT_FIELDS) as $field) {
            if ($request->filled($field)) {
                return true;
            }
        }

        if ($request->filled('landing_organizers_logo')) {
            return true;
        }

        if ($request->has('landing_organizers_map_use_all')
            || $request->has('landing_organizers_map_location_ids')) {
            return true;
        }

        for ($i = 1; $i <= self::ORGANIZERS_NETWORK_STAT_SLOTS; $i++) {
            if ($request->filled("landing_organizers_stat_{$i}_title")
                || $request->filled("landing_organizers_stat_{$i}_value")) {
                return true;
            }
        }

        if ($request->filled('landing_faq_section_label')
            || $request->filled('landing_media_section_label')
            || $request->filled('landing_media_json')) {
            return true;
        }

        for ($i = 0; $i < self::MEDIA_SLOTS; $i++) {
            if ($request->filled("landing_media_{$i}_file")) {
                return true;
            }
        }

        if ($request->filled('landing_faq_section_label')) {
            return true;
        }

        for ($i = 1; $i <= self::FAQ_SLOTS; $i++) {
            if ($request->filled("landing_faq_{$i}_question") || $request->filled("landing_faq_{$i}_answer")) {
                return true;
            }
        }

        return $request->filled('landing_hero_image')
            || $request->filled('landing_qr_image')
            || $request->filled('landing_countdown_at')
            || $request->filled('landing_countdown_end_at')
            || $request->filled('landing_about_images_main')
            || $request->filled('landing_about_images_secondary')
            || $request->filled('landing_reasons_title')
            || $request->filled('landing_reasons_desc');
    }

    private function syncSpeakersSection($landingPage, Request $request): void
    {
        $existing = $landingPage->speakersSection?->content ?? [];
        $content = $this->buildSpeakersContent($existing, $request);

        $landingPage->sections()->updateOrCreate(
            ['type' => EventLandingSection::TYPE_SPEAKERS],
            ['content' => $content, 'sort_order' => 40, 'is_active' => true]
        );
    }

    private function syncAgendaSection($landingPage, Request $request): void
    {
        $existing = $landingPage->agendaSection?->content ?? [];
        $content = $this->buildAgendaContent($existing, $request);

        $landingPage->sections()->updateOrCreate(
            ['type' => EventLandingSection::TYPE_AGENDA],
            ['content' => $content, 'sort_order' => 50, 'is_active' => true]
        );
    }

    private function syncOrganizersSection($landingPage, Request $request): void
    {
        $existing = $landingPage->organizersSection?->content ?? [];
        $content = $this->buildOrganizersContent($existing, $request);

        $landingPage->sections()->updateOrCreate(
            ['type' => EventLandingSection::TYPE_ORGANIZERS],
            ['content' => $content, 'sort_order' => 55, 'is_active' => true]
        );
    }

    private function syncPartnersSection($landingPage, Request $request): void
    {
        $existing = $landingPage->partnersSection?->content ?? [];
        $content = $this->buildPartnersContent($existing, $request);

        $landingPage->sections()->updateOrCreate(
            ['type' => EventLandingSection::TYPE_PARTNERS],
            ['content' => $content, 'sort_order' => 60, 'is_active' => true]
        );
    }

    private function syncLandingFaqSection($landingPage, Request $request): void
    {
        $existing = $landingPage->landingFaqSection?->content ?? [];
        $content = $this->buildLandingFaqContent($existing, $request);

        $landingPage->sections()->updateOrCreate(
            ['type' => EventLandingSection::TYPE_LANDING_FAQ],
            ['content' => $content, 'sort_order' => 70, 'is_active' => true]
        );
    }

    private function syncMediaSection($landingPage, Request $request): void
    {
        $existing = $landingPage->mediaSection?->content ?? [];
        $content = $this->buildLandingMediaContent($existing, $request);

        $landingPage->sections()->updateOrCreate(
            ['type' => EventLandingSection::TYPE_MEDIA],
            ['content' => $content, 'sort_order' => 75, 'is_active' => true]
        );
    }

    private function replaceUploadedFile(
        array &$target,
        string $key,
        ?string $oldPath,
        Request $request,
        string $inputName
    ): void {
        if (!$request->filled($inputName)) {
            return;
        }

        $newPath = $request->input($inputName);

        if ($oldPath && $oldPath !== $newPath) {
            $this->deleteOldFile($oldPath);
        }

        $target[$key] = $newPath;
    }

    private function buildHeroContent(array $existing, Request $request): array
    {
        $content = $existing;

        foreach (self::HERO_TEXT_FIELDS as $input => $key) {
            if ($request->has($input)) {
                $value = $request->input($input);
                $content[$key] = $value !== '' ? $value : null;
            }
        }

        if ($request->filled('landing_countdown_at')) {
            $content['countdown_at'] = $request->input('landing_countdown_at');
        } elseif ($request->has('landing_countdown_at') && $request->input('landing_countdown_at') === '') {
            unset($content['countdown_at']);
        }

        if ($request->filled('landing_countdown_end_at')) {
            $content['countdown_end_at'] = $request->input('landing_countdown_end_at');
        } elseif ($request->has('landing_countdown_end_at') && $request->input('landing_countdown_end_at') === '') {
            unset($content['countdown_end_at']);
        }

        if ($request->filled('landing_hero_image')) {
            if (!empty($existing['hero_image'])) {
                $this->deleteOldFile($existing['hero_image']);
            }
            $content['hero_image'] = $request->input('landing_hero_image');
        }

        if ($request->filled('landing_qr_image')) {
            if (!empty($existing['qr_image'])) {
                $this->deleteOldFile($existing['qr_image']);
            }
            $content['qr_image'] = $request->input('landing_qr_image');
        }

        if ($request->filled('landing_agenda_url')) {
            if (!empty($existing['agenda_url'])) {
                $this->deleteOldFile($existing['agenda_url']);
            }
            $content['agenda_url'] = $request->input('landing_agenda_url');
        }

        return $content;
    }

    private function buildAboutReasonsContent(array $existing, Request $request): array
    {
        $content = $existing;

        foreach (self::ABOUT_REASONS_TEXT_FIELDS as $input => $key) {
            if ($request->has($input)) {
                $value = $request->input($input);
                $content[$key] = $value !== '' ? $value : null;
            }
        }

        // About images
        if ($request->filled('landing_about_images_main')) {
            if (!empty(data_get($existing, 'about_images.main'))) {
                $this->deleteOldFile(data_get($existing, 'about_images.main'));
            }
            $content['about_images']['main'] = $request->input('landing_about_images_main');
        }

        if ($request->filled('landing_about_images_secondary')) {
            if (!empty(data_get($existing, 'about_images.secondary'))) {
                $this->deleteOldFile(data_get($existing, 'about_images.secondary'));
            }
            $content['about_images']['secondary'] = $request->input('landing_about_images_secondary');
        }

        $reasons = [];
        for ($i = 1; $i <= 3; $i++) {
            $iconInput = $request->input("landing_reason_{$i}_icon");
            $reasons[] = [
                'icon' => filled($iconInput)
                    ? $iconInput
                    : data_get($existing, 'reasons.' . ($i - 1) . '.icon'),
                'title' => $request->has("landing_reason_{$i}_title")
                    ? ($request->input("landing_reason_{$i}_title") ?: null)
                    : data_get($existing, 'reasons.' . ($i - 1) . '.title'),
                'description' => $request->has("landing_reason_{$i}_description")
                    ? ($request->input("landing_reason_{$i}_description") ?: null)
                    : data_get($existing, 'reasons.' . ($i - 1) . '.description'),
            ];
        }

        $content['reasons'] = $reasons;

        return $content;
    }

    private function buildStatsContent(array $existing, Request $request): array
    {
        $defaultIcons = ['bi-people-fill', 'bi-mic-fill', 'bi-mortarboard-fill', 'bi-calendar-event'];
        $stats = [];

        for ($i = 1; $i <= 4; $i++) {
            $iconInput = $request->input("landing_stat_{$i}_icon");
            $stats[] = [
                'icon' => filled($iconInput)
                    ? $iconInput
                    : (data_get($existing, 'stats.' . ($i - 1) . '.icon') ?: ($defaultIcons[$i - 1] ?? 'bi-star')),
                'value' => $request->has("landing_stat_{$i}_value")
                    ? ($request->input("landing_stat_{$i}_value") ?: null)
                    : data_get($existing, 'stats.' . ($i - 1) . '.value'),
                'label' => $request->has("landing_stat_{$i}_label")
                    ? ($request->input("landing_stat_{$i}_label") ?: null)
                    : data_get($existing, 'stats.' . ($i - 1) . '.label'),
            ];
        }

        return ['stats' => $stats];
    }

    private function buildDetailsMapContent(array $existing, Request $request): array
    {
        $content = $existing;

        foreach (self::DETAILS_MAP_TEXT_FIELDS as $input => $key) {
            if ($request->has($input)) {
                $value = $request->input($input);
                $content[$key] = $value !== '' ? $value : null;
            }
        }

        return $content;
    }

    private function buildSpeakersContent(array $existing, Request $request): array
    {
        $content = $existing;

        if ($request->has('landing_speakers_label')) {
            $content['section_label'] = $request->input('landing_speakers_label') ?: null;
        }

        // Read speakers from dynamic JSON input
        if ($request->filled('landing_speakers_json')) {
            $parsed = json_decode($request->input('landing_speakers_json'), true);
            if (is_array($parsed)) {
                // Merge with existing to preserve uploaded files
                $speakers = [];
                foreach ($parsed as $index => $item) {
                    $prev = data_get($existing, 'speakers.' . $index, []);
                    $speaker = [
                        'name' => $item['name'] ?? null,
                        'title' => $item['title'] ?? null,
                        'organization' => $item['organization'] ?? null,
                        'photo' => data_get($prev, 'photo'),
                        'org_logo' => data_get($prev, 'org_logo'),
                    ];
                    $this->replaceUploadedFile($speaker, 'photo', $speaker['photo'], $request, "landing_speaker_{$index}_photo");
                    $this->replaceUploadedFile($speaker, 'org_logo', $speaker['org_logo'], $request, "landing_speaker_{$index}_org_logo");
                    $speakers[] = $speaker;
                }
                $content['speakers'] = $speakers;
                return $content;
            }
        }

        // Fallback: legacy fixed-slot format
        $speakers = [];
        for ($i = 1; $i <= self::SPEAKER_SLOTS; $i++) {
            $prev = data_get($existing, 'speakers.' . ($i - 1), []);
            $speaker = [
                'name' => $request->has("landing_speaker_{$i}_name")
                    ? ($request->input("landing_speaker_{$i}_name") ?: null)
                    : data_get($prev, 'name'),
                'title' => $request->has("landing_speaker_{$i}_title")
                    ? ($request->input("landing_speaker_{$i}_title") ?: null)
                    : data_get($prev, 'title'),
                'organization' => $request->has("landing_speaker_{$i}_organization")
                    ? ($request->input("landing_speaker_{$i}_organization") ?: null)
                    : data_get($prev, 'organization'),
                'photo' => data_get($prev, 'photo'),
                'org_logo' => data_get($prev, 'org_logo'),
            ];

            $this->replaceUploadedFile($speaker, 'photo', $speaker['photo'], $request, "landing_speaker_{$i}_photo");
            $this->replaceUploadedFile($speaker, 'org_logo', $speaker['org_logo'], $request, "landing_speaker_{$i}_org_logo");

            $speakers[] = $speaker;
        }

        $content['speakers'] = $speakers;

        return $content;
    }

    private function buildAgendaContent(array $existing, Request $request): array
    {
        $content = $existing;

        if ($request->has('landing_agenda_section_label')) {
            $content['section_label'] = $request->input('landing_agenda_section_label') ?: null;
        }

        // Read agenda from dynamic JSON input
        if ($request->filled('landing_agenda_json')) {
            $parsed = json_decode($request->input('landing_agenda_json'), true);
            if (is_array($parsed)) {
                $content['items'] = $this->filterAgendaItems(array_map(function ($item) {
                    return [
                        'time' => $item['time'] ?? null,
                        'title' => $item['title'] ?? null,
                        'icon' => $item['icon'] ?? 'bi-clock',
                    ];
                }, $parsed));

                return $content;
            }
        }

        // Fallback: legacy fixed-slot format
        $defaultIcons = [
            'bi-cup-hot', 'bi-easel', 'bi-globe', 'bi-airplane',
            'bi-building', 'bi-person', 'bi-gift', 'bi-mic',
        ];

        $items = [];
        for ($i = 1; $i <= self::AGENDA_SLOTS; $i++) {
            $iconInput = $request->input("landing_agenda_{$i}_icon");
            $items[] = [
                'time' => $request->has("landing_agenda_{$i}_time")
                    ? ($request->input("landing_agenda_{$i}_time") ?: null)
                    : data_get($existing, 'items.' . ($i - 1) . '.time'),
                'title' => $request->has("landing_agenda_{$i}_title")
                    ? ($request->input("landing_agenda_{$i}_title") ?: null)
                    : data_get($existing, 'items.' . ($i - 1) . '.title'),
                'icon' => filled($iconInput)
                    ? $iconInput
                    : (data_get($existing, 'items.' . ($i - 1) . '.icon') ?: ($defaultIcons[$i - 1] ?? 'bi-circle')),
            ];
        }

        $content['items'] = $this->filterAgendaItems($items);

        return $content;
    }

    private function filterAgendaItems(array $items): array
    {
        return array_values(array_filter($items, function ($item) {
            return filled(data_get($item, 'time')) || filled(data_get($item, 'title'));
        }));
    }

    private function buildOrganizersContent(array $existing, Request $request): array
    {
        $content = $existing;

        foreach (self::ORGANIZERS_TEXT_FIELDS as $input => $key) {
            if ($request->has($input)) {
                $value = $request->input($input);
                $content[$key] = $value !== '' ? $value : null;
            }
        }

        $this->replaceUploadedFile($content, 'logo', $content['logo'] ?? null, $request, 'landing_organizers_logo');

        $defaultStats = [
            ['title' => 'Students', 'value' => '2,1M+', 'icon' => 'bi-mortarboard', 'image' => null],
            ['title' => 'Training Centers', 'value' => '2K+', 'icon' => null, 'image' => '/site/images/training_centers.png'],
            ['title' => 'Certified Trainers', 'value' => '4K+', 'icon' => null, 'image' => '/site/images/sales.png'],
            ['title' => 'Testing Centers', 'value' => '550+', 'icon' => null, 'image' => '/site/images/testing_centers.png'],
            ['title' => 'Invigilators', 'value' => '200+', 'icon' => 'bi-person-bounding-box', 'image' => null],
        ];

        $networkStats = [];
        for ($i = 1; $i <= self::ORGANIZERS_NETWORK_STAT_SLOTS; $i++) {
            $prev = data_get($existing, 'network_stats.' . ($i - 1), []);
            $fallback = $defaultStats[$i - 1] ?? [];

            $stat = [
                'title' => $request->has("landing_organizers_stat_{$i}_title")
                    ? ($request->input("landing_organizers_stat_{$i}_title") ?: null)
                    : (data_get($prev, 'title') ?: data_get($fallback, 'title')),
                'value' => $request->has("landing_organizers_stat_{$i}_value")
                    ? ($request->input("landing_organizers_stat_{$i}_value") ?: null)
                    : (data_get($prev, 'value') ?: data_get($fallback, 'value')),
                'icon' => $request->has("landing_organizers_stat_{$i}_icon")
                    ? ($request->input("landing_organizers_stat_{$i}_icon") ?: null)
                    : (data_get($prev, 'icon') ?: data_get($fallback, 'icon')),
                'image' => $request->has("landing_organizers_stat_{$i}_image")
                    ? ($request->input("landing_organizers_stat_{$i}_image") ?: null)
                    : (data_get($prev, 'image') ?: data_get($fallback, 'image')),
            ];

            $this->replaceUploadedFile(
                $stat,
                'image',
                $stat['image'],
                $request,
                "landing_organizers_stat_{$i}_image"
            );

            $stat = $this->resolveOrganizersStatVisual($stat);

            $networkStats[] = $stat;
        }

        $content['network_stats'] = $networkStats;

        if ($request->has('landing_organizers_map_use_all')) {
            $content['map_location_ids'] = $request->boolean('landing_organizers_map_use_all')
                ? null
                : array_values(array_unique(array_map('intval', $request->input('landing_organizers_map_location_ids', []))));
        } elseif ($request->has('landing_organizers_map_location_ids')) {
            $content['map_location_ids'] = array_values(array_unique(array_map(
                'intval',
                $request->input('landing_organizers_map_location_ids', [])
            )));
        }

        return $content;
    }

    /**
     * Icon and custom image are mutually exclusive (icon wins if both are set).
     */
    private function resolveOrganizersStatVisual(array $stat): array
    {
        if (filled($stat['icon'] ?? null)) {
            $oldImage = $stat['image'] ?? null;
            $stat['image'] = null;

            if ($oldImage && str_starts_with($oldImage, '/uploads/')) {
                $this->deleteOldFile($oldImage);
            }

            return $stat;
        }

        if (filled($stat['image'] ?? null)) {
            $stat['icon'] = null;
        }

        return $stat;
    }

    private function buildPartnersContent(array $existing, Request $request): array
    {
        $content = $existing;

        if ($request->has('landing_partners_label')) {
            $content['section_label'] = $request->input('landing_partners_label') ?: null;
        }

        // Read partners from dynamic JSON input
        if ($request->has('landing_partners_json')) {
            $parsed = json_decode($request->input('landing_partners_json'), true);
            if (!is_array($parsed)) {
                $parsed = [];
            }

            $partners = [];
            foreach ($parsed as $index => $item) {
                if (!is_array($item)) {
                    continue;
                }

                $prev = data_get($existing, 'partners.' . $index, []);
                $name = trim((string) ($item['name'] ?? ''));
                $info = trim((string) ($item['info'] ?? ''));
                $website = $this->normalizePartnerWebsite($item['website'] ?? null);
                $logoFromJson = trim((string) ($item['logo'] ?? ''));
                $logo = data_get($prev, 'logo');

                if ($request->filled("landing_partner_{$index}_logo")) {
                    $logo = $request->input("landing_partner_{$index}_logo");
                } elseif ($logoFromJson !== '') {
                    $logo = $logoFromJson;
                }

                $partner = [
                    'name' => $name !== '' ? $name : null,
                    'logo' => $logo ?: null,
                    'info' => $info !== '' ? mb_substr($info, 0, 1000) : null,
                    'website' => $website,
                ];

                $this->replaceUploadedFile($partner, 'logo', $partner['logo'], $request, "landing_partner_{$index}_logo");

                if (!filled($partner['name']) && !filled($partner['logo'])) {
                    continue;
                }

                $partners[] = $partner;
            }

            $content['partners'] = $partners;

            return $content;
        }

        // Fallback: legacy fixed-slot format
        $partners = [];
        for ($i = 1; $i <= self::PARTNER_SLOTS; $i++) {
            $prev = data_get($existing, 'partners.' . ($i - 1), []);
            $partner = [
                'name' => $request->has("landing_partner_{$i}_name")
                    ? ($request->input("landing_partner_{$i}_name") ?: null)
                    : data_get($prev, 'name'),
                'logo' => data_get($prev, 'logo'),
                'info' => data_get($prev, 'info'),
                'website' => data_get($prev, 'website'),
            ];

            $this->replaceUploadedFile($partner, 'logo', $partner['logo'], $request, "landing_partner_{$i}_logo");

            $partners[] = $partner;
        }

        $content['partners'] = $partners;

        return $content;
    }

    /**
     * Normalize partner website URL (add https if missing).
     */
    private function normalizePartnerWebsite($url): ?string
    {
        $url = trim((string) $url);
        if ($url === '') {
            return null;
        }
        if (!preg_match('#^https?://#i', $url)) {
            $url = 'https://' . $url;
        }
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return null;
        }

        return mb_substr($url, 0, 2048);
    }

    private function buildLandingFaqContent(array $existing, Request $request): array
    {
        $content = $existing;

        if ($request->has('landing_faq_section_label')) {
            $content['section_label'] = $request->input('landing_faq_section_label') ?: null;
        }

        // Read FAQ from dynamic JSON input
        if ($request->filled('landing_faq_json')) {
            $parsed = json_decode($request->input('landing_faq_json'), true);
            if (is_array($parsed)) {
                $content['items'] = array_map(function ($item) {
                    return [
                        'question' => $item['question'] ?? null,
                        'answer' => $item['answer'] ?? null,
                    ];
                }, $parsed);
                return $content;
            }
        }

        // Fallback: legacy fixed-slot format
        $items = [];
        for ($i = 1; $i <= self::FAQ_SLOTS; $i++) {
            $items[] = [
                'question' => $request->has("landing_faq_{$i}_question")
                    ? ($request->input("landing_faq_{$i}_question") ?: null)
                    : data_get($existing, 'items.' . ($i - 1) . '.question'),
                'answer' => $request->has("landing_faq_{$i}_answer")
                    ? ($request->input("landing_faq_{$i}_answer") ?: null)
                    : data_get($existing, 'items.' . ($i - 1) . '.answer'),
            ];
        }

        $content['items'] = $items;

        return $content;
    }

    private function buildLandingMediaContent(array $existing, Request $request): array
    {
        $content = $existing;

        if ($request->has('landing_media_section_label')) {
            $content['section_label'] = $request->input('landing_media_section_label') ?: null;
        }

        if (!$request->has('landing_media_json')) {
            return $content;
        }

        $parsed = json_decode($request->input('landing_media_json'), true);
        if (!is_array($parsed)) {
            $parsed = [];
        }

        $items = [];
        foreach ($parsed as $index => $item) {
            if (!is_array($item)) {
                continue;
            }

            $prev = data_get($existing, 'items.' . $index, []);
            $type = ($item['type'] ?? '') === 'video' ? 'video' : 'image';
            $title = trim((string) ($item['title'] ?? ''));
            $url = trim((string) ($item['url'] ?? ''));

            if ($type === 'video') {
                if ($url === '') {
                    continue;
                }

                $items[] = [
                    'type' => 'video',
                    'title' => $title !== '' ? $title : null,
                    'url' => $url,
                    'file' => null,
                ];

                continue;
            }

            $file = data_get($prev, 'file');
            if ($request->filled("landing_media_{$index}_file")) {
                $file = $request->input("landing_media_{$index}_file");
            } elseif (!empty($item['file'])) {
                $file = $item['file'];
            }

            $mediaItem = [
                'type' => 'image',
                'title' => $title !== '' ? $title : null,
                'url' => null,
                'file' => $file ?: null,
            ];

            $this->replaceUploadedFile($mediaItem, 'file', $mediaItem['file'], $request, "landing_media_{$index}_file");

            if (!filled($mediaItem['file'])) {
                continue;
            }

            $items[] = $mediaItem;
        }

        $content['items'] = $items;

        return $content;
    }
}
