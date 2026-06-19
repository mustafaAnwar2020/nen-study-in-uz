@php
    /** @var \App\Models\Event $event */
    $items = $event->getAgendaItems();
    $agendaPdfUrl = $event->getLandingAgendaUrl();
    $showAgendaPdfBtn = $agendaPdfUrl && !str_starts_with($agendaPdfUrl, '#');

    $resolveAgendaIcon = function (array $item): string {
        $iconRaw = trim((string) data_get($item, 'icon', 'bi-clock'));
        $icon = str_replace('bi bi-', 'bi-', $iconRaw);
        if (!str_starts_with($icon, 'bi-')) {
            $icon = 'bi-' . ltrim($icon, '-');
        }

        $iconAliases = [
            'bi-cup-hot-fill' => 'bi-cup',
            'bi-cup-hot' => 'bi-cup',
            'bi-globe2' => 'bi-globe',
            'bi-people-fill' => 'bi-people',
            'bi-gift-fill' => 'bi-briefcase',
            'bi-flag-fill' => 'bi-flag',
            'bi-question-lg' => 'bi-question-circle',
        ];
        $icon = $iconAliases[$icon] ?? $icon;

        $supportedIcons = [
            'bi-cup', 'bi-mic', 'bi-globe', 'bi-people', 'bi-airplane',
            'bi-briefcase', 'bi-person', 'bi-calendar-check', 'bi-book',
            'bi-flag', 'bi-gift', 'bi-clock', 'bi-journal-check', 'bi-building',
        ];

        $title = strtolower((string) data_get($item, 'title', ''));
        if (!in_array($icon, $supportedIcons, true)) {
            if (str_contains($title, 'coffee') || str_contains($title, 'break')) {
                return 'bi-cup';
            }
            if (str_contains($title, 'welcome') || str_contains($title, 'speech')) {
                return 'bi-mic';
            }
            if (str_contains($title, 'global') || str_contains($title, 'toefl')) {
                return 'bi-globe';
            }
            if (str_contains($title, 'discussion') || str_contains($title, 'panel')) {
                return 'bi-people';
            }
            if (str_contains($title, 'partnership')) {
                return 'bi-briefcase';
            }
            if (str_contains($title, 'closing') || str_contains($title, 'lunch')) {
                return 'bi-calendar-check';
            }

            return 'bi-clock';
        }

        return $icon;
    };
@endphp
@if($event->shouldShowAgendaSection())
    <section id="agenda" class="event-landing-agenda section" aria-labelledby="event-landing-agenda-title">
        <div class="container">
            <div class="event-landing-agenda__header">
                <h2 id="event-landing-agenda-title" class="event-landing-section-title mb-0">{{ $event->getAgendaSectionLabel() }}</h2>
                <div class="event-landing-agenda__header-actions">
                    @if($showAgendaPdfBtn)
                        <a href="{{ $agendaPdfUrl }}"
                           class="btn event-landing-agenda__pdf-btn"
                           target="_blank"
                           rel="noopener noreferrer">
                            {{ $event->getLandingAgendaLabel() }}
                        </a>
                    @endif
                    <button type="button" class="event-landing-agenda__scroll-btn event-landing-agenda__scroll-btn--next" aria-label="Scroll agenda">
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="event-landing-agenda__track">
                <div class="event-landing-agenda__timeline">
                    @foreach($items as $item)
                        <div class="event-landing-agenda__column">
                            <div class="event-landing-agenda__icon" aria-hidden="true">
                                <i class="bi {{ $resolveAgendaIcon($item) }}"></i>
                            </div>
                            @if(data_get($item, 'time'))
                                <p class="event-landing-agenda__time">{{ data_get($item, 'time') }}</p>
                            @endif
                            @if(data_get($item, 'title'))
                                <p class="event-landing-agenda__session">{{ data_get($item, 'title') }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
