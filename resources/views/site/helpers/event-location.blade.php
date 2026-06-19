@php
    /** @var \App\Models\Event $event */
    $addressLine = $event->getAddressLine();
    $countryName = $event->getCountryName();
@endphp
<div class="event-location-meta">
    @if($event->time)
        <span class="event-location-meta__time">
            <i class="bi bi-clock" aria-hidden="true"></i>
            <span>{{ $event->time }}</span>
        </span>
    @endif
    @if($event->isOnline())
        <span class="event-venue-badge {{ $event->getVenueTypeBadgeClass() }}">
            <i class="bi bi-camera-video" aria-hidden="true"></i>
            {{ $event->getVenueTypeLabel() }}
        </span>
    @else
        <span class="event-venue-badge {{ $event->getVenueTypeBadgeClass() }}">
            <i class="bi bi-building" aria-hidden="true"></i>
            {{ $event->getVenueTypeLabel() }}
        </span>
        @if($addressLine || $countryName)
            <span class="event-location-meta__place">
                <i class="bi bi-geo-alt-fill" aria-hidden="true"></i>
                @if($addressLine)
                    <span class="event-location-meta__address">{{ $addressLine }}</span>
                @endif
                @if($addressLine && $countryName)
                    <span class="event-location-meta__sep" aria-hidden="true">·</span>
                @endif
                @if($countryName)
                    <span class="event-location-meta__country">{{ $countryName }}</span>
                    @if($event->country_code)
                        <span class="flag-icon flag-icon-{{ $event->country_code }}" aria-hidden="true"></span>
                    @endif
                @endif
            </span>
        @endif
    @endif
</div>
