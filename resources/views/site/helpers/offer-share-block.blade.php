@php
    $isSpecial = !empty($offer->is_special);
    $shareUrl = ($isSpecial && !empty($offer->slug))
        ? route('site.offers', ['special' => $offer->slug])
        : route('site.offers');
    $shareText = $offer->name;
    $shareUrlEnc = rawurlencode($shareUrl);
    $shareTextEnc = rawurlencode($shareText);
@endphp
<div class="offer-share{{ !empty($shareClass) ? ' ' . $shareClass : '' }}" aria-label="Share this offer">
    <span class="offer-share__label">Share</span>
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrlEnc }}"
       class="offer-share__btn offer-share__btn--fb"
       target="_blank" rel="noopener noreferrer"
       title="Share on Facebook"
       aria-label="Share on Facebook"><i class="bi bi-facebook" aria-hidden="true"></i></a>
    <a href="https://twitter.com/intent/tweet?url={{ $shareUrlEnc }}&text={{ $shareTextEnc }}"
       class="offer-share__btn offer-share__btn--tw"
       target="_blank" rel="noopener noreferrer"
       title="Share on X (Twitter)"
       aria-label="Share on X (Twitter)"><i class="bi bi-twitter" aria-hidden="true"></i></a>
    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrlEnc }}"
       class="offer-share__btn offer-share__btn--li"
       target="_blank" rel="noopener noreferrer"
       title="Share on LinkedIn"
       aria-label="Share on LinkedIn"><i class="bi bi-linkedin" aria-hidden="true"></i></a>
    <a href="https://wa.me/?text={{ rawurlencode($shareText . ' ' . $shareUrl) }}"
       class="offer-share__btn offer-share__btn--wa"
       target="_blank" rel="noopener noreferrer"
       title="Share on WhatsApp"
       aria-label="Share on WhatsApp"><i class="bi bi-whatsapp" aria-hidden="true"></i></a>
</div>
