<div class="modal fade offer-details-modal bd-example-modal-lg" id="offerDetails{{ $offer->id }}" tabindex="-1" role="dialog" aria-labelledby="offerDetailsTitle{{ $offer->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0 rounded-4 shadow overflow-hidden">
            <div class="modal-header border-0 py-2 px-3">
                <h2 class="visually-hidden" id="offerDetailsTitle{{ $offer->id }}">{{ $offer->name }}</h2>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 px-3 pb-3">
                <article class="special-offer-card special-offer-card--modal-detail">
                    <div class="special-offer-card__inner" data-offer-site-media data-offer-id="{{ $offer->id }}">
                        <div class="special-offer-card__media">
                            @include('site.helpers.offer-site-media', ['offer' => $offer, 'tabsPlacement' => 'body'])
                        </div>
                        <div class="special-offer-card__body">
                            <div class="special-offer-card__label">Details</div>
                            @if($offer->date)
                                <div class="special-offer-card__date">Expires on: {{ $offer->date }}</div>
                            @endif
                            <h3 class="special-offer-card__title">{{ $offer->name }}</h3>
                            <div
                                class="special-offer-card__desc-wrap{{ $offer->description ? '' : ' special-offer-card__desc-wrap--empty' }}"
                                @if(!$offer->description) aria-hidden="true" @endif
                            >
                                @if($offer->description)
                                    <p class="special-offer-card__desc">{{ strip_tags($offer->description) }}</p>
                                @endif
                            </div>
                            @if($offer->date)
                                <div class="counter" data-date="{{ $offer->date }}">
                                    <div class="time days"></div>
                                    <span>:</span>
                                    <div class="time hours"></div>
                                    <span>:</span>
                                    <div class="time minutes"></div>
                                    <span>:</span>
                                    <div class="time seconds"></div>
                                </div>
                            @endif
                            <div class="special-offer-card__actions">
                                @include('site.helpers.offer-book-now-button', [
                                    'offer' => $offer,
                                    'buttonClass' => 'btn btn-dark special-offer-card__btn',
                                    'wrapperClass' => '',
                                ])
                                @include('site.helpers.offer-more-details-link', [
                                    'offer' => $offer,
                                    'linkClass' => 'btn btn-outline-dark special-offer-card__btn text-decoration-none',
                                ])
                            </div>
                            @include('site.helpers.special-offer-toolbar', ['offer' => $offer])
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
