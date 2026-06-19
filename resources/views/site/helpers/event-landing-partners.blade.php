@php
    /** @var \App\Models\Event $event */
    $partners = $event->getPartners();
@endphp
@if($event->shouldShowPartnersSection())
    <section id="partners" class="event-landing-partners section" aria-labelledby="event-landing-partners-title">
        <div class="container">
            <h2 id="event-landing-partners-title" class="event-landing-section-title">{{ $event->getPartnersSectionLabel() }}</h2>
            <div class="event-landing-partners__grid">
                @foreach($partners as $index => $partner)
                    @php
                        $hasInfo = filled(data_get($partner, 'info'));
                        $partnerName = data_get($partner, 'name') ?: 'Partner';
                        $logoUrl = \App\Models\Event::landingAsset(data_get($partner, 'logo'));
                    @endphp
                    <article class="event-landing-partners__card">
                        @if($logoUrl)
                            @if($hasInfo)
                                <button type="button"
                                        class="event-landing-partners__logo event-landing-partners__logo--interactive"
                                        data-partner-index="{{ $index }}"
                                        aria-label="More about {{ $partnerName }}"
                                        aria-haspopup="dialog">
                                    <img src="{{ $logoUrl }}" alt="{{ $partnerName }}" loading="lazy">
                                </button>
                            @else
                                <div class="event-landing-partners__logo">
                                    <img src="{{ $logoUrl }}" alt="{{ $partnerName }}" loading="lazy">
                                </div>
                            @endif
                        @endif
                        @if(data_get($partner, 'name'))
                            <p class="event-landing-partners__name">{{ data_get($partner, 'name') }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    @php
        $hasAnyPartnerInfo = collect($partners)->contains(function ($p) {
            return filled(data_get($p, 'info'));
        });
    @endphp
    @if($hasAnyPartnerInfo)
        <div class="modal fade event-landing-partner-modal" id="eventPartnerInfoModal" tabindex="-1"
             aria-labelledby="eventPartnerInfoModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content event-landing-partner-modal__content">
                    <div class="modal-header border-0 pb-0">
                        <h3 class="modal-title event-landing-partner-modal__title" id="eventPartnerInfoModalTitle"></h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body event-landing-partner-modal__body pt-2"></div>
                    <div class="modal-footer border-0 pt-0 event-landing-partner-modal__footer" style="display: none;">
                        <a href="#" class="btn btn-primary event-landing-partner-modal__link" target="_blank" rel="noopener noreferrer">
                            Visit website
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <script type="application/json" id="event-partners-info-data">
            {!! json_encode(array_map(function ($p) {
                return [
                    'name' => data_get($p, 'name'),
                    'info' => data_get($p, 'info'),
                    'website' => data_get($p, 'website'),
                ];
            }, $partners), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) !!}
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var dataEl = document.getElementById('event-partners-info-data');
                var modalEl = document.getElementById('eventPartnerInfoModal');
                if (!dataEl || !modalEl) {
                    return;
                }

                var partnersData = [];
                try {
                    partnersData = JSON.parse(dataEl.textContent || '[]');
                } catch (e) {
                    return;
                }

                var titleEl = modalEl.querySelector('.event-landing-partner-modal__title');
                var bodyEl = modalEl.querySelector('.event-landing-partner-modal__body');
                var footerEl = modalEl.querySelector('.event-landing-partner-modal__footer');
                var linkEl = modalEl.querySelector('.event-landing-partner-modal__link');
                var modal = typeof bootstrap !== 'undefined' && bootstrap.Modal
                    ? new bootstrap.Modal(modalEl)
                    : null;

                document.querySelectorAll('.event-landing-partners__logo--interactive').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        var idx = parseInt(btn.getAttribute('data-partner-index'), 10);
                        var item = partnersData[idx];
                        if (!item || !item.info) {
                            return;
                        }

                        titleEl.textContent = item.name || 'Partner';
                        bodyEl.textContent = item.info;

                        if (item.website) {
                            linkEl.href = item.website;
                            footerEl.style.display = '';
                        } else {
                            linkEl.removeAttribute('href');
                            footerEl.style.display = 'none';
                        }

                        if (modal) {
                            modal.show();
                        } else if (typeof $ !== 'undefined' && $(modalEl).modal) {
                            $(modalEl).modal('show');
                        }
                    });
                });
            });
        </script>
    @endif
@endif
