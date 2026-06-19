@php
    /** @var \App\Models\Event $event */
    $countdownStartIso = $event->getLandingCountdownIso();
    $countdownEndIso = $event->getLandingCountdownEndIso();
@endphp

@if($countdownStartIso || $countdownEndIso)
    <div class="event-landing-countdown-bridge" aria-label="Event countdown">
        <div class="container">
            <div class="event-landing-countdown-bridge__row">
                @if($countdownStartIso)
                    <div class="event-landing-countdown-card" data-event-countdown data-date="{{ $countdownStartIso }}">
                        <p class="event-landing-countdown-card__label">Event starts in</p>
                        <div class="event-landing-countdown-card__grid">
                            <div class="event-landing-countdown-card__unit">
                                <span class="event-landing-countdown-card__value days">00</span>
                                <span class="event-landing-countdown-card__name">Days</span>
                            </div>
                            <span class="event-landing-countdown-card__sep" aria-hidden="true">:</span>
                            <div class="event-landing-countdown-card__unit">
                                <span class="event-landing-countdown-card__value hours">00</span>
                                <span class="event-landing-countdown-card__name">HRS</span>
                            </div>
                            <span class="event-landing-countdown-card__sep" aria-hidden="true">:</span>
                            <div class="event-landing-countdown-card__unit">
                                <span class="event-landing-countdown-card__value minutes">00</span>
                                <span class="event-landing-countdown-card__name">MINS</span>
                            </div>
                            <span class="event-landing-countdown-card__sep" aria-hidden="true">:</span>
                            <div class="event-landing-countdown-card__unit">
                                <span class="event-landing-countdown-card__value seconds">00</span>
                                <span class="event-landing-countdown-card__name">SECS</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if($countdownEndIso)
                    <div class="event-landing-countdown-card" data-event-countdown data-date="{{ $countdownEndIso }}">
                        <p class="event-landing-countdown-card__label">Registration ends in</p>
                        <div class="event-landing-countdown-card__grid">
                            <div class="event-landing-countdown-card__unit">
                                <span class="event-landing-countdown-card__value days">00</span>
                                <span class="event-landing-countdown-card__name">Days</span>
                            </div>
                            <span class="event-landing-countdown-card__sep" aria-hidden="true">:</span>
                            <div class="event-landing-countdown-card__unit">
                                <span class="event-landing-countdown-card__value hours">00</span>
                                <span class="event-landing-countdown-card__name">HRS</span>
                            </div>
                            <span class="event-landing-countdown-card__sep" aria-hidden="true">:</span>
                            <div class="event-landing-countdown-card__unit">
                                <span class="event-landing-countdown-card__value minutes">00</span>
                                <span class="event-landing-countdown-card__name">MINS</span>
                            </div>
                            <span class="event-landing-countdown-card__sep" aria-hidden="true">:</span>
                            <div class="event-landing-countdown-card__unit">
                                <span class="event-landing-countdown-card__value seconds">00</span>
                                <span class="event-landing-countdown-card__name">SECS</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
