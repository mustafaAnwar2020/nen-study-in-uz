@php
    /** @var \App\Models\Event $event */
    $addressLine = $event->getAddressLine();
    $countryName = $event->getCountryName();
@endphp
<div class="swiper-slide card shadow p-3 event-card-slide">
    <article class="event-card service-item position-relative text-center" aria-labelledby="event-card-title-{{ $event->id }}">
        <div class="event-card__media icon mb-4">
            <img src="{{ $event->getImage() }}" alt="{{ $event->name }}" class="img-fluid" loading="lazy">
        </div>
        <div class="event-card__footer d-flex justify-content-between align-items-end pb-3 gap-2 flex-wrap">
            <div class="event-card-actions d-flex flex-wrap gap-2">
                @if($event->book_now_url)
                    <a href="{{ $event->book_now_url }}"
                       class="btn btn-custom-dark"
                       target="_blank"
                       rel="noopener noreferrer"
                       onclick="event.stopPropagation();">
                        Book now
                    </a>
                @endif
                @include('site.helpers.event-show-more', ['event' => $event, 'stopPropagation' => true])
            </div>
            <div class="event-card-meta text-md-end flex-grow-1">
                <h3 class="h5 mb-1" id="event-card-title-{{ $event->id }}">{{ limitText($event->name, 28) }}</h3>
                @if($event->date)
                    <div class="event-card-meta__date">
                        <i class="bi bi-calendar-event" aria-hidden="true"></i>
                        <span>{{ $event->date }}</span>
                    </div>
                @endif
                <div class="event-card-meta__venue">
                    <span class="event-venue-badge {{ $event->getVenueTypeBadgeClass() }} event-venue-badge--compact">
                        @if($event->isOnline())
                            <i class="bi bi-camera-video" aria-hidden="true"></i>
                        @else
                            <i class="bi bi-building" aria-hidden="true"></i>
                        @endif
                        {{ $event->getVenueTypeLabel() }}
                    </span>
                </div>
                @if(!$event->isOnline() && ($addressLine || $countryName))
                    <div class="event-card-meta__location">
                        <span class="event-card-meta__place">
                            <i class="bi bi-geo-alt-fill" aria-hidden="true"></i>
                            @if($addressLine)
                                <span class="event-card-meta__address">{{ $addressLine }}</span>
                            @endif
                            @if($addressLine && $countryName)
                                <span class="event-card-meta__sep" aria-hidden="true">·</span>
                            @endif
                            @if($countryName)
                                <span class="event-card-meta__country">{{ $countryName }}</span>
                                @if($event->country_code)
                                    <span class="flag-icon flag-icon-{{ $event->country_code }}" aria-hidden="true"></span>
                                @endif
                            @endif
                        </span>
                    </div>
                @endif
            </div>
        </div>
        @if($event->hasLandingPage())
            <a href="{{ $event->getLandingPageUrl() }}"
               class="event-card__hitarea"
               aria-label="View event page for {{ $event->name }}"></a>
        @else
            <button type="button"
                    class="event-card__hitarea"
                    onclick="showEventDetails(this, '{{ $event->id }}')"
                    aria-label="View details for {{ $event->name }}"></button>
        @endif
    </article>
</div>
