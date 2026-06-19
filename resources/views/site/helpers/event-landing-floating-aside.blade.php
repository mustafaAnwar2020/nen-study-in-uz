@php
    /** @var \App\Models\Event $event */
    $hasWhatsapp = filled($event->getLandingWhatsappUrl());
    $hasTelegram = filled($event->getLandingTelegramUrl());
    $hasFaq = filled($event->getLandingFaqUrl());
@endphp

@if($hasWhatsapp || $hasTelegram || $hasFaq)
    <aside class="event-landing-page-rail" aria-label="Quick links">
        <nav class="event-landing-page-rail__social" aria-label="Quick links">
            @if($hasWhatsapp)
                <a href="{{ $event->getLandingWhatsappUrl() }}"
                   class="floating-icon whatsapp"
                   target="_blank"
                   rel="noopener noreferrer"
                   title="WhatsApp">
                    <i class="bi bi-whatsapp" aria-hidden="true"></i>
                </a>
            @endif
            @if($hasTelegram)
                <a href="{{ $event->getLandingTelegramUrl() }}"
                   class="floating-icon telegram"
                   target="_blank"
                   rel="noopener noreferrer"
                   title="Telegram">
                    <i class="bi bi-telegram" aria-hidden="true"></i>
                </a>
            @endif
            @if($hasFaq)
                <a href="{{ $event->getLandingFaqUrl() }}"
                   class="floating-icon faq"
                   title="FAQ">
                    <i class="bi bi-question-circle" aria-hidden="true"></i>
                </a>
            @endif
        </nav>
    </aside>
@endif
