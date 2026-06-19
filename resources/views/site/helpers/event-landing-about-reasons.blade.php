@php
    /** @var \App\Models\Event $event */
    $content = $event->aboutReasonsSectionContent();
    $aboutLabel = data_get($content, 'about_label');
    $aboutTitle = data_get($content, 'about_title');
    $aboutTitleDisplay = $aboutTitle
        ? preg_replace('/(?<=[a-z])(?=[A-Z])/', ' ', $aboutTitle)
        : null;
    $aboutDescription = data_get($content, 'about_description');
    $paragraphs = $aboutDescription
        ? preg_split('/\r\n|\r|\n\s*\n/', trim($aboutDescription), -1, PREG_SPLIT_NO_EMPTY)
        : [];
    $aboutImages = data_get($content, 'about_images', []);
    $mainImage = data_get($aboutImages, 'main') ? asset(data_get($aboutImages, 'main')) : null;
    $secondaryImage = data_get($aboutImages, 'secondary') ? asset(data_get($aboutImages, 'secondary')) : null;
    $reasonsLabel = data_get($content, 'reasons_label');
    $reasonsTitle = data_get($content, 'reasons_title');
    $reasonsDesc = data_get($content, 'reasons_desc');
    $cards = $event->getAboutReasonsCards();
@endphp
@if($event->shouldShowAboutReasonsSection())
    {{-- About section --}}
    <section id="about" class="event-landing-about section" aria-labelledby="event-landing-about-title">
        <div class="container">
            <div class="row g-4 g-lg-5 align-items-start">
                <div class="col-lg-6 event-landing-about__intro">
                    @if($aboutLabel)
                        <p class="event-landing-about__eyebrow">{{ $aboutLabel }}</p>
                    @endif
                    @if($aboutTitleDisplay)
                        <h2 id="event-landing-about-title" class="event-landing-about__title">{!! nl2br(e($aboutTitleDisplay)) !!}</h2>
                    @endif
                    @if($paragraphs)
                        <div class="event-landing-about__text">
                            @foreach($paragraphs as $paragraph)
                                <p>{{ trim($paragraph) }}</p>
                            @endforeach
                        </div>
                    @endif
                    {{-- <a href="#" class="event-landing-about__read-more">
                        Read more
                        <i class="bi bi-arrow-right-short" style="font-size: 1.25rem; font-weight: 700;" aria-hidden="true"></i>
                    </a> --}}
                </div>

                <div class="col-lg-6">
                    @if($mainImage || $secondaryImage)
                        <div class="event-landing-about__images">
                            @if($mainImage)
                                <img src="{{ $mainImage }}" alt="" class="event-landing-about__img-main" loading="lazy">
                            @endif
                            @if($secondaryImage)
                                <img src="{{ $secondaryImage }}" alt="" class="event-landing-about__img-secondary" loading="lazy">
                            @endif

                            <div class="event-landing-about__badge event-landing-about__badge--speakers">
                                <span class="event-landing-about__badge-icon">
                                    <i class="bi bi-mic"></i>
                                </span>
                                <span class="event-landing-about__badge-text">Expert Speakers</span>
                            </div>
                            <div class="event-landing-about__badge event-landing-about__badge--experience">
                                <span class="event-landing-about__badge-icon">
                                    <i class="bi bi-award"></i>
                                </span>
                                <span class="event-landing-about__badge-text">Tailored Experience</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Reasons section --}}
    @if($cards)
        <section class="event-landing-reasons section" aria-labelledby="event-landing-reasons-title">
            <div class="container">
                <div class="row g-4 g-lg-5 align-items-start">
                    <div class="col-lg-5">
                        @if($reasonsLabel)
                            <p class="event-landing-reasons__eyebrow">{{ $reasonsLabel }}</p>
                        @endif
                        @if($reasonsTitle)
                            <h2 id="event-landing-reasons-title" class="event-landing-reasons__title">{!! nl2br(e($reasonsTitle)) !!}</h2>
                        @endif
                        @if($reasonsDesc)
                            <p class="event-landing-reasons__desc">{{ $reasonsDesc }}</p>
                        @endif
                    </div>
                    <div class="col-lg-7">
                        <div class="event-landing-reasons__grid">
                            @foreach($cards as $card)
                                <div class="event-landing-reasons__card">
                                    <div class="event-landing-reasons__card-icon
                                        {{ data_get($card, 'icon') === 'bi-globe' ? 'event-landing-reasons__card-icon--blue' : '' }}
                                        {{ data_get($card, 'icon') === 'bi-tools' || data_get($card, 'icon') === 'bi-briefcase-fill' ? 'event-landing-reasons__card-icon--red' : '' }}
                                        event-landing-reasons__card-icon--default"
                                        aria-hidden="true">
                                        <i class="bi {{ data_get($card, 'icon', 'bi-star') }}"></i>
                                    </div>
                                    <div class="event-landing-reasons__card-body">
                                        @if(data_get($card, 'title'))
                                            <h3 class="event-landing-reasons__card-title">{{ data_get($card, 'title') }}</h3>
                                        @endif
                                        @if(data_get($card, 'description'))
                                            <p class="event-landing-reasons__card-text">{{ data_get($card, 'description') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endif
