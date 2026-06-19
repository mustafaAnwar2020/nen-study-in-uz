@php
    /** @var \App\Models\Event $event */
    $agendaUrl = $event->getLandingAgendaUrl();
    $registerUrl = $event->book_now_url ?: '#';
    $qrImage = $event->getLandingQrImage();
    $heroBg = $event->getLandingHeroImage();
    $dateLabel = $event->getLandingDateLabel();
    $timeLabel = $event->getLandingTimeLabel();
    $locationLabel = $event->getLandingLocationLabel();
    $googleCalendarUrl = $event->getLandingGoogleCalendarUrl();
@endphp
<section class="event-landing-hero section position-relative" aria-labelledby="event-landing-hero-title">
    @if($heroBg)
        <div class="event-landing-hero__bg" aria-hidden="true">
            <img src="{{ $heroBg }}" alt="">
        </div>
    @else
        <div class="event-landing-hero__bg" style="background: #2F363C;" aria-hidden="true"></div>
    @endif

    @if($qrImage)
        <aside class="event-landing-hero__qr-wrap" aria-label="Registration QR code">
            <div class="event-landing-hero__qr-card">
                <p class="event-landing-hero__qr-title">Scan to Register</p>
                <img src="{{ $qrImage }}" alt="QR code to register for {{ strip_tags($event->getLandingTitle()) }}" class="event-landing-hero__qr-image">
                <p class="event-landing-hero__qr-foot">Secure your seat Today!</p>
            </div>
        </aside>
    @endif

    <div class="container event-landing-hero__container">
        <div class="row align-items-start">
            <div class="col-lg-7 event-landing-hero__content">
                <h1 id="event-landing-hero-title" class="event-landing-hero__title">
                    {!! nl2br(e($event->getLandingTitle())) !!}@if($event->getLandingTitleHighlight()) <span class="event-landing-hero__title-highlight">{{ $event->getLandingTitleHighlight() }}</span>@endif
                </h1>

                @if($event->getLandingDescription())
                    <p class="event-landing-hero__lead">{{ strip_tags($event->getLandingDescription()) }}</p>
                @endif

                <ul class="event-landing-hero__meta list-unstyled">
                    @if($dateLabel)
                        <li>
                            <i class="bi bi-calendar-event" aria-hidden="true"></i>
                            <span>{{ $dateLabel }}</span>
                        </li>
                    @endif
                    @if($timeLabel)
                        <li>
                            <i class="bi bi-clock" aria-hidden="true"></i>
                            <span>{{ $timeLabel }}</span>
                        </li>
                    @endif
                    @if($locationLabel)
                        <li>
                            <i class="bi bi-geo-alt" aria-hidden="true"></i>
                            <span>{{ $locationLabel }}</span>
                        </li>
                    @endif
                </ul>

                <div class="event-landing-hero__actions">
                    <a href="{{ $registerUrl }}"
                       class="btn event-landing-hero__btn event-landing-hero__btn--primary"
                       @if($event->book_now_url) target="_blank" rel="noopener noreferrer" @endif>
                        {{ $event->getLandingRegisterLabel() }}
                        <i class="bi bi-arrow-up-right" aria-hidden="true"></i>
                    </a>
                    @if($agendaUrl)
                        <a href="{{ $agendaUrl }}"
                           class="btn event-landing-hero__btn event-landing-hero__btn--secondary"
                           @if(!str_starts_with($agendaUrl, '#')) target="_blank" rel="noopener noreferrer" @endif>
                            {{ $event->getLandingAgendaLabel() }}
                        </a>
                    @endif
                    @if($googleCalendarUrl)
                        <a href="{{ $googleCalendarUrl }}"
                           class="btn event-landing-hero__btn event-landing-hero__btn--secondary"
                           target="_blank"
                           rel="noopener noreferrer">
                            <i class="bi bi-calendar-plus" aria-hidden="true"></i>
                            Add to Google Calendar
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
