@php
    $mImg = !empty($offer->image);
    $mVid = !empty($offer->video);
    $mPdf = !empty($offer->pdf);
    $mCount = ($mImg ? 1 : 0) + ($mVid ? 1 : 0) + ($mPdf ? 1 : 0);
    $first = $mImg ? 'img' : ($mVid ? 'video' : 'pdf');
    $tabsPlacement = $tabsPlacement ?? 'media';
@endphp
@if($mCount === 0)
    @if($tabsPlacement === 'body')
        <div class="offer-site-media offer-site-media--empty" role="img" aria-label="{{ $offer->name }}"></div>
    @else
        <div class="offer-site-media offer-site-media--empty" data-offer-site-media role="img" aria-label="{{ $offer->name }}"></div>
    @endif
@else
    @if($tabsPlacement === 'body')
        <div class="offer-site-media">
            <div class="offer-site-media__panes">
                @if($mImg)
                    <div class="offer-site-media__pane{{ $first === 'img' ? ' is-active' : '' }}" data-media-pane="img" role="tabpanel">
                        <img
                            src="{{ $offer->getImage() }}"
                            alt="{{ $offer->name }}"
                            class="clickable-image offer-site-media__lightbox-img"
                            data-bs-toggle="modal"
                            data-bs-target="#imageModal"
                        >
                    </div>
                @endif
                @if($mVid)
                    <div class="offer-site-media__pane offer-site-media__pane--video{{ $first === 'video' ? ' is-active' : '' }}" data-media-pane="video" role="tabpanel">
                        <video controls playsinline preload="none" src="{{ asset($offer->video) }}">
                            <a href="{{ asset($offer->video) }}">Download video</a>
                        </video>
                        <button
                            type="button"
                            class="offer-site-media__video-expand"
                            data-bs-toggle="modal"
                            data-bs-target="#offerHtml5VideoModal"
                            data-video-src="{{ asset($offer->video) }}"
                            data-video-title="{{ $offer->name }}"
                            aria-label="{{ __('Open video in larger view') }}"
                        >
                            <i class="bi bi-arrows-fullscreen" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif
                @if($mPdf)
                    @php
                        $pdfUrl = asset($offer->pdf);
                        $pdfDownloadName = \Illuminate\Support\Str::slug(\Illuminate\Support\Str::limit($offer->name, 80, '')) ?: 'offer';
                        $pdfDownloadName .= '-' . $offer->id . '.pdf';
                    @endphp
                    <div class="offer-site-media__pane offer-site-media__pane--pdf{{ $first === 'pdf' ? ' is-active' : '' }}" data-media-pane="pdf" role="tabpanel">
                        <div class="offer-site-media__pdf-panel">
                            <i class="bi bi-file-earmark-pdf offer-site-media__pdf-icon" aria-hidden="true"></i>
                            <p class="offer-site-media__pdf-title">PDF attachment</p>
                            <div class="offer-site-media__pdf-actions">
                                <a href="{{ $pdfUrl }}"
                                   class="btn btn-sm btn-dark offer-site-media__pdf-download"
                                   download="{{ $pdfDownloadName }}"
                                   rel="noopener">Download PDF</a>
                                <a href="{{ $pdfUrl }}"
                                   class="btn btn-sm btn-outline-secondary offer-site-media__pdf-open"
                                   target="_blank"
                                   rel="noopener">Open in new tab</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="offer-site-media" data-offer-site-media data-offer-id="{{ $offer->id }}">
            @if($mCount > 1)
                <div class="offer-site-media__tabs" role="tablist" aria-label="Offer media">
                    @if($mImg)
                        <button type="button" role="tab" class="offer-site-media__tab{{ $first === 'img' ? ' active' : '' }}"
                                data-media-tab-btn="img"
                                aria-selected="{{ $first === 'img' ? 'true' : 'false' }}">Photo</button>
                    @endif
                    @if($mVid)
                        <button type="button" role="tab" class="offer-site-media__tab{{ $first === 'video' ? ' active' : '' }}"
                                data-media-tab-btn="video"
                                data-video-src="{{ asset($offer->video) }}"
                                data-video-title="{{ $offer->name }}"
                                aria-selected="{{ $first === 'video' ? 'true' : 'false' }}">Video</button>
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
                            src="{{ $offer->getImage() }}"
                            alt="{{ $offer->name }}"
                            class="clickable-image offer-site-media__lightbox-img"
                            data-bs-toggle="modal"
                            data-bs-target="#imageModal"
                        >
                    </div>
                @endif
                @if($mVid)
                    <div class="offer-site-media__pane offer-site-media__pane--video{{ $first === 'video' ? ' is-active' : '' }}" data-media-pane="video" role="tabpanel">
                        <video controls playsinline preload="none" src="{{ asset($offer->video) }}">
                            <a href="{{ asset($offer->video) }}">Download video</a>
                        </video>
                        <button
                            type="button"
                            class="offer-site-media__video-expand"
                            data-bs-toggle="modal"
                            data-bs-target="#offerHtml5VideoModal"
                            data-video-src="{{ asset($offer->video) }}"
                            data-video-title="{{ $offer->name }}"
                            aria-label="{{ __('Open video in larger view') }}"
                        >
                            <i class="bi bi-arrows-fullscreen" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif
                @if($mPdf)
                    @php
                        $pdfUrl = asset($offer->pdf);
                        $pdfDownloadName = \Illuminate\Support\Str::slug(\Illuminate\Support\Str::limit($offer->name, 80, '')) ?: 'offer';
                        $pdfDownloadName .= '-' . $offer->id . '.pdf';
                    @endphp
                    <div class="offer-site-media__pane offer-site-media__pane--pdf{{ $first === 'pdf' ? ' is-active' : '' }}" data-media-pane="pdf" role="tabpanel">
                        <div class="offer-site-media__pdf-panel">
                            <i class="bi bi-file-earmark-pdf offer-site-media__pdf-icon" aria-hidden="true"></i>
                            <p class="offer-site-media__pdf-title">PDF attachment</p>
                            <div class="offer-site-media__pdf-actions">
                                <a href="{{ $pdfUrl }}"
                                   class="btn btn-sm btn-dark offer-site-media__pdf-download"
                                   download="{{ $pdfDownloadName }}"
                                   rel="noopener">Download PDF</a>
                                <a href="{{ $pdfUrl }}"
                                   class="btn btn-sm btn-outline-secondary offer-site-media__pdf-open"
                                   target="_blank"
                                   rel="noopener">Open in new tab</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endif
