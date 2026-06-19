@php
    /** @var \App\Models\Event $event */
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    $dateLabel = $event->date ? Carbon::parse($event->date)->format('F j, Y') : null;
    $yearLabel = $event->date ? Carbon::parse($event->date)->format('Y') : null;
    $description = Str::limit(strip_tags($event->getLandingDescription() ?? ''), 160);
    $location = $event->getLandingLocationLabel();
    $eventTitle = $event->getLandingTitle();
@endphp
<article class="nen-archive-card">
    <div class="nen-archive-card__media">
        <img src="{{ $event->getImage() }}" alt="{{ $eventTitle }}" loading="lazy">
        @if($yearLabel)
            <span class="nen-archive-card__year">{{ $yearLabel }}</span>
        @endif
    </div>
    <div class="nen-archive-card__body">
        @if($location || $dateLabel)
            <div class="nen-archive-card__meta">
                @if($location)
                    <span class="nen-archive-card__meta-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg>
                        {{ $location }}
                    </span>
                @endif
                @if($dateLabel)
                    <span class="nen-archive-card__meta-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 4h-1V2h-2v2H8V2H6v2H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2zm0 16H5V10h14v10z"/></svg>
                        {{ $dateLabel }}
                    </span>
                @endif
            </div>
        @endif
        <h3 class="nen-archive-card__title">{{ $eventTitle }}</h3>
        @if($description)
            <p class="nen-archive-card__desc">{{ $description }}</p>
        @endif
        <div class="nen-archive-card__actions">
            @if($event->hasLandingPage())
                <a href="{{ $event->getLandingPageUrl() }}" class="nen-archive-card__btn">View Full Archive</a>
            @else
                <button type="button" class="nen-archive-card__btn" onclick="showEventDetails(this, '{{ $event->id }}')">
                    View Full Archive
                </button>
            @endif
            <button type="button"
                    class="nen-archive-card__btn nen-archive-card__btn--request"
                    data-event-id="{{ $event->id }}"
                    data-event-title="{{ e($eventTitle) }}">
                Request this event
            </button>
        </div>
    </div>
</article>
