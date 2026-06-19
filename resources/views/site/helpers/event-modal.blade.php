<div class="modal fade event-details-modal offer-details-modal bd-example-modal-lg" id="eventDetails{{ $event->id }}" tabindex="-1" role="dialog" aria-labelledby="eventDetailsTitle{{ $event->id }}" aria-hidden="true" style="z-index: 999999999;">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0 rounded-4 shadow overflow-hidden">
            <div class="modal-header border-0 py-2 px-3">
                <h2 class="visually-hidden" id="eventDetailsTitle{{ $event->id }}">{{ $event->name }}</h2>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close event details"></button>
            </div>
            <div class="modal-body pt-0 px-3 pb-3">
                <article class="special-offer-card special-offer-card--modal-detail event-detail-card">
                    <div class="special-offer-card__inner" data-offer-site-media data-offer-id="{{ $event->id }}">
                        <div class="special-offer-card__media">
                            @include('site.helpers.event-site-media', ['event' => $event, 'tabsPlacement' => 'body'])
                        </div>
                        <div class="special-offer-card__body">
                            <div class="special-offer-card__label">Event details</div>
                            @if($event->date)
                                <div class="special-offer-card__date event-detail-card__date">
                                    <i class="bi bi-calendar-event" aria-hidden="true"></i>
                                    {{ $event->date }}
                                    @if($event->time)
                                        <span class="event-detail-card__time">· {{ $event->time }}</span>
                                    @endif
                                </div>
                            @endif
                            <h3 class="special-offer-card__title">{{ $event->name }}</h3>
                            <div class="event-detail-card__meta">
                                @include('site.helpers.event-location', ['event' => $event])
                            </div>
                            <div class="special-offer-card__desc-wrap{{ $event->description ? '' : ' special-offer-card__desc-wrap--empty' }}"
                                 @if(!$event->description) aria-hidden="true" @endif>
                                @if($event->description)
                                    <div class="special-offer-card__desc event-detail-card__desc">{!! nl2br(e(strip_tags($event->description))) !!}</div>
                                @endif
                            </div>
                            @include('site.helpers.event-share-block', ['event' => $event])
                            <div class="special-offer-card__actions event-detail-card__actions">
                                @if($event->book_now_url)
                                    <a target="_blank" rel="noopener noreferrer" href="{{ $event->book_now_url }}"
                                       class="btn btn-dark special-offer-card__btn text-decoration-none">
                                        Book now
                                    </a>
                                @endif
                            </div>
                            @include('site.helpers.event-site-media-tabs', ['event' => $event])
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
