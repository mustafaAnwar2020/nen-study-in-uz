@php
    /** @var \App\Models\Event $event */
    $addressLine = $event->getAddressLine();
    $countryName = $event->getCountryName();
@endphp
<div class="card shadow position-relative events-page-card w-100 h-100 text-center">
    <article class="event-card event-card--grid d-flex flex-column h-100" aria-labelledby="event-grid-title-{{ $event->id }}">
        <div class="event-card__media icon flex-shrink-0">
            <img src="{{ $event->getImage() }}" alt="{{ $event->name }}" class="img-fluid" loading="lazy">
        </div>
        <div class="event-card__body card-body-wrap flex-grow-1 d-flex flex-column">
            <h3 class="h5 mb-2" id="event-grid-title-{{ $event->id }}">{{ $event->name }}</h3>
            @if($event->date)
                <div class="event-card-meta__date text-muted small mb-2">
                    <i class="bi bi-calendar-event" aria-hidden="true"></i>
                    <span>{{ $event->date }}</span>
                </div>
            @endif
            <div class="event-card-meta__venue mb-2">
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
                <div class="event-card-meta__location small text-muted mb-3">
                    <span class="event-card-meta__place justify-content-center">
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
            @else
                <div class="mb-3"></div>
            @endif
            <div class="event-card-actions mt-auto d-flex flex-wrap gap-2 justify-content-center">
                @if($event->book_now_url)
                    <a href="{{ $event->book_now_url }}"
                       class="btn btn-dark"
                       target="_blank"
                       rel="noopener noreferrer">
                        Book now
                    </a>
                @endif
                @include('site.helpers.event-show-more', ['event' => $event, 'buttonClass' => 'btn btn-outline-dark'])
            </div>
        </div>
    </article>
</div>
