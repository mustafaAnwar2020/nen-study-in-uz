@php
    /** @var \App\Models\Event $event */
    $speakers = $event->getSpeakers();
@endphp
@if($event->shouldShowSpeakersSection())
    <section id="speakers" class="event-landing-speakers section" aria-labelledby="event-landing-speakers-title">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h2 id="event-landing-speakers-title" class="event-landing-section-title mb-0">{{ $event->getSpeakersSectionLabel() }}</h2>
                <div class="d-flex gap-2">
                    <button type="button" class="event-landing-speakers__scroll-btn event-landing-speakers__scroll-btn--prev" aria-label="Previous speakers">
                        <i class="bi bi-chevron-left" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="event-landing-speakers__scroll-btn event-landing-speakers__scroll-btn--next" aria-label="Next speakers">
                        <i class="bi bi-chevron-right" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="event-landing-speakers__scroll">
                <div class="event-landing-speakers__track">
                    @foreach($speakers as $speaker)
                        <article class="event-landing-speakers__card">
                            @if($photo = \App\Models\Event::landingAsset(data_get($speaker, 'photo')))
                                <div class="event-landing-speakers__photo">
                                    <img src="{{ $photo }}" alt="{{ data_get($speaker, 'name') }}" loading="lazy">
                                </div>
                            @endif
                            <div class="event-landing-speakers__body">
                                @if(data_get($speaker, 'name'))
                                    <h3 class="event-landing-speakers__name">{{ data_get($speaker, 'name') }}</h3>
                                @endif
                                @if(data_get($speaker, 'title'))
                                    <p class="event-landing-speakers__role">{{ data_get($speaker, 'title') }}</p>
                                @endif
                            </div>
                            {{-- @if($logo = \App\Models\Event::landingAsset(data_get($speaker, 'org_logo')))
                                <div class="event-landing-speakers__org-logo">
                                    <img src="{{ $logo }}" alt="" loading="lazy">
                                </div>
                            @endif --}}
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
