@php
    /** @var \App\Models\Event $event */
    $items = $event->getMediaItems();
@endphp
@if($event->shouldShowMediaSection())
    <section id="media" class="event-landing-media section" aria-labelledby="event-landing-media-title">
        <div class="container">
            <h2 id="event-landing-media-title" class="event-landing-section-title">{{ $event->getMediaSectionLabel() }}</h2>
            <div class="event-landing-media__grid">
                @foreach($items as $item)
                    @php
                        $type = data_get($item, 'type') === 'video' ? 'video' : 'image';
                        $title = data_get($item, 'title');
                        $fileUrl = \App\Models\Event::landingAsset(data_get($item, 'file'));
                        $youtubeEmbed = $type === 'video'
                            ? \App\Models\Event::landingMediaYoutubeEmbed(data_get($item, 'url'))
                            : null;
                    @endphp
                    <article class="event-landing-media__card">
                        @if($title)
                            <h3 class="event-landing-media__card-title">{{ $title }}</h3>
                        @endif

                        @if($type === 'image' && $fileUrl)
                            <div class="event-landing-media__pane event-landing-media__pane--image">
                                <img src="{{ $fileUrl }}" alt="{{ $title ?: 'Media image' }}"
                                     class="clickable-image event-landing-media__img"
                                     data-bs-toggle="modal" data-bs-target="#imageModal" loading="lazy">
                            </div>
                        @elseif($type === 'video' && $youtubeEmbed)
                            <div class="event-landing-media__pane event-landing-media__pane--video">
                                <div class="event-landing-media__video-ratio">
                                    <iframe src="{{ $youtubeEmbed }}" title="{{ $title ?: 'YouTube video' }}"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen loading="lazy"></iframe>
                                </div>
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
