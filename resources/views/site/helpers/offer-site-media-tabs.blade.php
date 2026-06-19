@php
    $mImg = !empty($offer->image);
    $mVid = !empty($offer->video);
    $mPdf = !empty($offer->pdf);
    $mCount = ($mImg ? 1 : 0) + ($mVid ? 1 : 0) + ($mPdf ? 1 : 0);
    $first = $mImg ? 'img' : ($mVid ? 'video' : 'pdf');
@endphp
@if($mCount > 1)
    <div class="offer-site-media__tabs offer-site-media__tabs--in-body" role="tablist" aria-label="{{ __('Offer media') }}">
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
