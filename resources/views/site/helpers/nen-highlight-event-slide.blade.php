@php
    /** @var \App\Models\Event $event */
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    $isLive = $event->date && Carbon::parse($event->date)->isToday();
    $dateLabel = $event->date ? Carbon::parse($event->date)->format('d-m-Y') : null;
    $description = Str::limit(strip_tags($event->getLandingDescription() ?? ''), 200);
    $location = $event->getLandingLocationLabel();
@endphp
<div class="swiper-slide">
    <article class="nen-highlight-card">
        <div class="nen-highlight-card__media">
            <img src="{{ $event->getImage() }}" alt="{{ $event->getLandingTitle() }}" loading="lazy">
        </div>
        <div class="nen-highlight-card__body">
            <div class="nen-highlight-card__meta">
                @if($isLive)
                    <span class="nen-highlight-card__live">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 8a4 4 0 014 4 4 4 0 01-4 4 4 4 0 01-4-4 4 4 0 014-4z"/></svg>
                        Live now
                    </span>
                @else
                    <span></span>
                @endif
                @if($dateLabel)
                    <span class="nen-highlight-card__date">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 4h-1V2h-2v2H8V2H6v2H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2zm0 16H5V10h14v10z"/></svg>
                        {{ $dateLabel }}
                    </span>
                @endif
            </div>
            <h3 class="nen-highlight-card__title">{{ $event->getLandingTitle() }}</h3>
            @if($description)
                <p class="nen-highlight-card__desc">{{ $description }}</p>
            @endif
            @if($location)
                <div class="nen-highlight-card__location">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg>
                    {{ $location }}
                </div>
            @endif
            <div class="nen-highlight-card__actions">
                @if($event->book_now_url)
                    <a href="{{ $event->book_now_url }}"
                       class="nen-highlight-card__btn nen-highlight-card__btn--primary"
                       target="_blank"
                       rel="noopener noreferrer">
                        Book now
                    </a>
                @endif
                @if($event->hasLandingPage())
                    <a href="{{ $event->getLandingPageUrl() }}" class="nen-highlight-card__btn nen-highlight-card__btn--secondary">
                        Read more
                    </a>
                @else
                    <button type="button"
                            class="nen-highlight-card__btn nen-highlight-card__btn--secondary"
                            onclick="showEventDetails(this, '{{ $event->id }}')">
                        Read more
                    </button>
                @endif
            </div>
        </div>
    </article>
</div>
