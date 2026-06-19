@php
    /** @var \App\Models\Event $event */
    $registerUrl = $event->book_now_url ?: '#';
    $phone = $settings['general']->phone ?? '+998908227567/68';
@endphp
<header id="event-landing-header" class="event-landing-header">
    <div class="container event-landing-header__inner">
        <a href="{{ route('site.index') }}" class="event-landing-header__brand" aria-label="NEN home">
            <img src="{{ asset($settings['media']->logo) }}" alt="NEN" class="event-landing-header__logo event-landing-header__logo--nen">
            <img src="{{ asset('assets/landing-ets.png') }}" alt="ETS" class="event-landing-header__logo event-landing-header__logo--ets">
        </a>

        <nav class="event-landing-header__nav" aria-label="Landing navigation">
            <a href="#about" class="event-landing-header__nav-link">About</a>
            <a href="#organizers" class="event-landing-header__nav-link">Organizers</a>
            <a href="#speakers" class="event-landing-header__nav-link">Speakers</a>
            <a href="#agenda" class="event-landing-header__nav-link">Agenda</a>
        </nav>

        <div class="event-landing-header__actions">
            <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="event-landing-header__phone">
                <i class="bi bi-telephone"></i>
                <span>{{ $phone }}</span>
            </a>

            <a href="{{ $registerUrl }}" class="event-landing-header__register" @if($event->book_now_url) target="_blank" rel="noopener noreferrer" @endif>
                {{ $event->getLandingRegisterLabel() }}
                <i class="bi bi-arrow-up-right"></i>
            </a>

            {{-- <div class="event-landing-header__lang">
                <a href="#" class="translate-trigger" data-lang="en">EN</a>
                <span>|</span>
                <a href="#" class="translate-trigger" data-lang="uz">UZ</a>
            </div> --}}
        </div>
    </div>
</header>
