@php
    /** @var \App\Models\Offer $offer */
@endphp
<div class="special-offer-card__toolbar" role="group" aria-label="Offer media and sharing">
    <div class="special-offer-card__toolbar-media">
        @include('site.helpers.offer-site-media-tabs', ['offer' => $offer])
    </div>
    @include('site.helpers.offer-share-block', ['offer' => $offer, 'shareClass' => 'offer-share--toolbar'])
</div>
