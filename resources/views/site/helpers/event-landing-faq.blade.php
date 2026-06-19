@php
    /** @var \App\Models\Event $event */
    $items = $event->getLandingFaqItems();
    $faqUid = 'event-landing-faq-' . $event->id;
@endphp
@if($event->shouldShowLandingFaqSection())
    <section id="faq" class="event-landing-faq section" aria-labelledby="event-landing-faq-title">
        <div class="container">
            <h2 id="event-landing-faq-title" class="event-landing-faq__title">FAQs</h2>
            <div class="event-landing-faq__list" id="{{ $faqUid }}">
                @foreach($items as $index => $item)
                    @php
                        $collapseId = $faqUid . '-item-' . $index;
                        $headingId = $collapseId . '-heading';
                    @endphp
                    <div class="accordion-item event-landing-faq__item border-0">
                        <h3 class="accordion-header" id="{{ $headingId }}">
                            <button class="accordion-button collapsed event-landing-faq__trigger"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#{{ $collapseId }}"
                                    aria-expanded="false"
                                    aria-controls="{{ $collapseId }}">
                                <span>{{ data_get($item, 'question') }}</span>
                                <i class="bi bi-plus faq-icon" aria-hidden="true"></i>
                            </button>
                        </h3>
                        <div id="{{ $collapseId }}"
                             class="accordion-collapse collapse"
                             aria-labelledby="{{ $headingId }}">
                            <div class="accordion-body event-landing-faq__answer">
                                @if(filled(data_get($item, 'answer')))
                                    {!! nl2br(e(data_get($item, 'answer'))) !!}
                                @else
                                    <span class="text-muted">Answer coming soon.</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
