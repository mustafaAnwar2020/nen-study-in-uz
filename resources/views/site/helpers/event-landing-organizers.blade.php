@php
    /** @var \App\Models\Event $event */
    $networkStats = $event->getOrganizersNetworkStats();
    $hasMap = isset($locationsJson) && count($locationsJson) > 0;
@endphp
@if($event->shouldShowOrganizersSection())
    <section id="organizers" class="event-landing-organizers section" aria-labelledby="event-landing-organizers-title">
        <div class="container">
            <h2 id="event-landing-organizers-title" class="event-landing-section-title">{{ $event->getOrganizersSectionLabel() }}</h2>

            <div class="row gy-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="event-landing-organizers__brand text-center text-lg-start">
                        <img src="{{ $event->getOrganizersLogoUrl() }}" alt="NEN" width="200" class="event-landing-organizers__logo">
                        @if($description = $event->getOrganizersDescription())
                            <div class="event-landing-organizers__description mt-4">
                                {!! $description !!}
                            </div>
                        @endif
                        @if($event->getOrganizersBtnText() && $event->getOrganizersBtnUrl())
                            <div class="event-landing-organizers__actions mt-4 mb-3">
                                <a href="{{ $event->getOrganizersBtnUrl() }}" target="_blank" rel="noopener noreferrer"
                                   class="read-more btn-custom-danger">
                                    <span>{{ $event->getOrganizersBtnText() }}</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                                @if($event->getOrganizersPartnerBtnText() && $event->getOrganizersPartnerBtnUrl())
                                    <a href="{{ $event->getOrganizersPartnerBtnUrl() }}" target="_blank" rel="noopener noreferrer"
                                       class="read-more btn-custom-dark event-landing-organizers__partner-btn">
                                        <span>{{ $event->getOrganizersPartnerBtnText() }}</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                @endif
                            </div>
                        @elseif($event->getOrganizersPartnerBtnText() && $event->getOrganizersPartnerBtnUrl())
                            <div class="event-landing-organizers__actions mt-4 mb-3">
                                <a href="{{ $event->getOrganizersPartnerBtnUrl() }}" target="_blank" rel="noopener noreferrer"
                                   class="read-more btn-custom-dark event-landing-organizers__partner-btn">
                                    <span>{{ $event->getOrganizersPartnerBtnText() }}</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                    @if($hasMap && isset($locationFlags))
                        <div class="d-flex map_flags flex-wrap event-landing-organizers__flags">
                            @foreach($locationFlags as $location)
                                <a href="javascript:void(0)" data-code="{{ $location->country_code . '_' . $location->id }}"
                                   data-lat="{{ $location->latitude }}" data-lng="{{ $location->longitude }}"
                                   title="{{ $location->name }}" class="flag_map">
                                    <i class="flag-icon flag-icon-{{ $location->country_code }}"></i>
                                </a>
                            @endforeach
                        </div>

                        <div class="map-legend">
                            <div class="legend-item">
                                <div class="legend-marker main-office"></div>
                                <span class="legend-text text-danger">MAIN OFFICES</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-marker authorized-office"></div>
                                <span class="legend-text text-primary">AUTHORIZED OFFICES</span>
                            </div>
                        </div>

                        <div id="eventLandingNenMap" class="event-landing-organizers__map mb-4"></div>
                    @endif

                    @if(count($networkStats))
                        <div class="stats-container mt-4 event-landing-organizers__stats">
                            @foreach($networkStats as $stat)
                                <div class="stat-item">
                                    @if($icon = data_get($stat, 'icon'))
                                        <i class="bi {{ $icon }} icon"></i>
                                    @elseif($image = \App\Models\Event::landingAsset(data_get($stat, 'image')))
                                        <img src="{{ $image }}" height="30" alt="">
                                    @endif
                                    @if(data_get($stat, 'title'))
                                        <div class="title">{{ data_get($stat, 'title') }}</div>
                                    @endif
                                    @if(data_get($stat, 'value'))
                                        <div class="value">{{ data_get($stat, 'value') }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif
