@php
    /** @var \App\Models\Event $event */
    $mImg = !empty($event->image);
    $mPdf = !empty($event->pdf);
    $mCount = ($mImg ? 1 : 0) + ($mPdf ? 1 : 0);
    $first = $mImg ? 'img' : 'pdf';
    $tabsPlacement = $tabsPlacement ?? 'media';
@endphp
@if($mCount === 0)
    @if($tabsPlacement === 'body')
        <div class="offer-site-media offer-site-media--empty" role="img" aria-label="{{ $event->name }}"></div>
    @else
        <div class="offer-site-media offer-site-media--empty" data-offer-site-media role="img" aria-label="{{ $event->name }}"></div>
    @endif
@else
    @if($tabsPlacement === 'body')
        <div class="offer-site-media">
            <div class="offer-site-media__panes">
                @if($mImg)
                    <div class="offer-site-media__pane{{ $first === 'img' ? ' is-active' : '' }}" data-media-pane="img" role="tabpanel">
                        <img
                            src="{{ $event->getImage() }}"
                            alt="{{ $event->name }}"
                            class="clickable-image offer-site-media__lightbox-img"
                            data-bs-toggle="modal"
                            data-bs-target="#imageModal"
                        >
                    </div>
                @endif
                @if($mPdf)
                    @php
                        $pdfUrl = asset($event->pdf);
                        $pdfDownloadName = \Illuminate\Support\Str::slug(\Illuminate\Support\Str::limit($event->name, 80, '')) ?: 'event';
                        $pdfDownloadName .= '-' . $event->id . '.pdf';
                    @endphp
                    <div class="offer-site-media__pane offer-site-media__pane--pdf{{ $first === 'pdf' ? ' is-active' : '' }}" data-media-pane="pdf" role="tabpanel">
                        @include('site.helpers.event-pdf-panel', ['pdfUrl' => $pdfUrl, 'pdfDownloadName' => $pdfDownloadName])
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="offer-site-media" data-offer-site-media data-offer-id="{{ $event->id }}">
            @if($mCount > 1)
                <div class="offer-site-media__tabs" role="tablist" aria-label="Event media">
                    @if($mImg)
                        <button type="button" role="tab" class="offer-site-media__tab{{ $first === 'img' ? ' active' : '' }}"
                                data-media-tab-btn="img"
                                aria-selected="{{ $first === 'img' ? 'true' : 'false' }}">Photo</button>
                    @endif
                    @if($mPdf)
                        <button type="button" role="tab" class="offer-site-media__tab{{ $first === 'pdf' ? ' active' : '' }}"
                                data-media-tab-btn="pdf"
                                aria-selected="{{ $first === 'pdf' ? 'true' : 'false' }}">PDF</button>
                    @endif
                </div>
            @endif
            <div class="offer-site-media__panes">
                @if($mImg)
                    <div class="offer-site-media__pane{{ $first === 'img' ? ' is-active' : '' }}" data-media-pane="img" role="tabpanel">
                        <img
                            src="{{ $event->getImage() }}"
                            alt="{{ $event->name }}"
                            class="clickable-image offer-site-media__lightbox-img"
                            data-bs-toggle="modal"
                            data-bs-target="#imageModal"
                        >
                    </div>
                @endif
                @if($mPdf)
                    @php
                        $pdfUrl = asset($event->pdf);
                        $pdfDownloadName = \Illuminate\Support\Str::slug(\Illuminate\Support\Str::limit($event->name, 80, '')) ?: 'event';
                        $pdfDownloadName .= '-' . $event->id . '.pdf';
                    @endphp
                    <div class="offer-site-media__pane offer-site-media__pane--pdf{{ $first === 'pdf' ? ' is-active' : '' }}" data-media-pane="pdf" role="tabpanel">
                        @include('site.helpers.event-pdf-panel', ['pdfUrl' => $pdfUrl, 'pdfDownloadName' => $pdfDownloadName])
                    </div>
                @endif
            </div>
        </div>
    @endif
@endif
