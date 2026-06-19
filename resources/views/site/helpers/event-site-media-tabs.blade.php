@php
    /** @var \App\Models\Event $event */
    $mImg = !empty($event->image);
    $mPdf = !empty($event->pdf);
    $mCount = ($mImg ? 1 : 0) + ($mPdf ? 1 : 0);
    $first = $mImg ? 'img' : 'pdf';
@endphp
@if($mCount > 1)
    <div class="offer-site-media__tabs offer-site-media__tabs--in-body" role="tablist" aria-label="Event media">
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
