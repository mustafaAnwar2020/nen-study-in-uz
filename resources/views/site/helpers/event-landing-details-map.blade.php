@php
    /** @var \App\Models\Event $event */
    $mapSrc = $event->getDetailsMapEmbedSrc();
    $venueName = $event->getDetailsMapVenue();
    $address = $event->getDetailsMapAddress();
@endphp
@if($event->shouldShowDetailsMapSection())
    <section class="event-landing-details section" aria-labelledby="event-landing-details-title">
        <div class="container">
            <div class="event-landing-details__inner">
                <div class="event-landing-details__content">
                    @if($event->getDetailsMapLabel())
                        <p class="event-landing-details__eyebrow">{{ $event->getDetailsMapLabel() }}</p>
                    @endif
                    @if($event->getDetailsMapTitle())
                        <h2 id="event-landing-details-title" class="event-landing-details__title">{{ $event->getDetailsMapTitle() }}</h2>
                    @endif
                    @if($event->getDetailsMapDescription())
                        <p class="event-landing-details__lead">{{ $event->getDetailsMapDescription() }}</p>
                    @endif
                    <ul class="event-landing-details__list list-unstyled">
                        @if($event->getDetailsMapDate())
                            <li>
                                <i class="bi bi-calendar-event" aria-hidden="true"></i>
                                <span><strong>Date:</strong> {{ $event->getDetailsMapDate() }}</span>
                            </li>
                        @endif
                        @if($event->getDetailsMapTime())
                            <li>
                                <i class="bi bi-clock" aria-hidden="true"></i>
                                <span><strong>Time:</strong> {{ $event->getDetailsMapTime() }}</span>
                            </li>
                        @endif
                        @if($venueName)
                            <li>
                                <i class="bi bi-geo-alt" aria-hidden="true"></i>
                                <span><strong>Venue:</strong> {{ $venueName }}@if($address), {{ $address }}@endif</span>
                            </li>
                        @endif
                        @if($address && !$venueName)
                            <li>
                                <i class="bi bi-pin-map" aria-hidden="true"></i>
                                <span><strong>Address:</strong> {{ $address }}</span>
                            </li>
                        @endif
                    </ul>
                </div>

                @if($mapSrc)
                    <div class="event-landing-details__map-wrap">
                        <div class="event-landing-details__map">
                            <iframe
                                src="{{ $mapSrc }}"
                                title="Event location map"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                allowfullscreen></iframe>
                        </div>

                        {{-- Directions card overlay --}}
                        <div class="event-landing-details__directions">
                            <div class="event-landing-details__directions-info">
                                @if($venueName)
                                    <p class="event-landing-details__directions-name">{{ $venueName }}</p>
                                @endif
                                @if($address)
                                    <p class="event-landing-details__directions-address">{{ $address }}</p>
                                @endif
                                <div class="event-landing-details__directions-reviews">
                                    <span class="event-landing-details__directions-rating">4.5</span>
                                    <span class="event-landing-details__directions-stars">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </span>
                                    <span class="event-landing-details__directions-count">126 Reviews</span>
                                </div>
                            </div>
                            <a href="https://maps.google.com/?q={{ urlencode($venueName ?: $address) }}" target="_blank" rel="noopener noreferrer" class="event-landing-details__directions-link">
                                <i class="bi bi-arrow-up-right"></i>
                                <span>Directions</span>
                            </a>
                        </div>

                        {{-- Zoom controls --}}
                        <div class="event-landing-details__map-zoom">
                            <button type="button" class="event-landing-details__map-zoom-btn" aria-label="Zoom in" onclick="document.querySelector('.event-landing-details__map iframe').contentWindow.postMessage('zoomIn', '*')">
                                <i class="bi bi-plus"></i>
                            </button>
                            <div class="event-landing-details__map-zoom-btn--divider"></div>
                            <button type="button" class="event-landing-details__map-zoom-btn" aria-label="Zoom out" onclick="document.querySelector('.event-landing-details__map iframe').contentWindow.postMessage('zoomOut', '*')">
                                <i class="bi bi-dash"></i>
                            </button>
                        </div>

                        <a href="https://maps.google.com/?q={{ urlencode($venueName ?: $address) }}" target="_blank" rel="noopener noreferrer" class="event-landing-details__view-larger">
                            View Larger Map
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
