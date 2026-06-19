@php
    $bookBtnClass = $buttonClass ?? 'btn btn-dark';
    $links = $offer->use_book_now ? $offer->getBookNowUrl() : [];
    $bookNowText = trim((string)($offer->book_now_text ?? '')) ?: 'Book Now';
    $forBtnGroup = !empty($forBtnGroup);
    $fullWidth = !empty($fullWidth);
    $fwGroup = $fullWidth ? ' w-100' : '';
    $fwBtn = $fullWidth ? ' w-100 d-flex align-items-center justify-content-center' : '';
@endphp
@if($offer->use_book_now && count($links))
    @if($forBtnGroup)
        <div class="btn-group{{ $fwGroup }} {{ $wrapperClass ?? '' }}" role="group">
            <button class="{{ $bookBtnClass }} dropdown-toggle{{ $fwBtn }}" type="button" id="offerBookNow-{{ $offer->id }}"
                    data-bs-toggle="dropdown" aria-expanded="false">
                {{ $bookNowText }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="offerBookNow-{{ $offer->id }}">
                @foreach($links as $entry)
                    <li>
                        <a class="dropdown-item" target="_blank" rel="noopener" href="{{ $entry->url }}">
                            <span class="flag-icon flag-icon-{{ $entry->country }}"></span>
                            {{ config('countries')[$entry->country] ?? $entry->country }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="dropdown {{ $fullWidth ? 'd-block w-100' : 'd-inline-block' }} {{ $wrapperClass ?? '' }}">
            <button class="{{ $bookBtnClass }} dropdown-toggle{{ $fwBtn }}" type="button" id="offerBookNow-{{ $offer->id }}"
                    data-bs-toggle="dropdown" aria-expanded="false">
                {{ $bookNowText }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="offerBookNow-{{ $offer->id }}">
                @foreach($links as $entry)
                    <li>
                        <a class="dropdown-item" target="_blank" rel="noopener" href="{{ $entry->url }}">
                            <span class="flag-icon flag-icon-{{ $entry->country }}"></span>
                            {{ config('countries')[$entry->country] ?? $entry->country }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
@elseif(!empty($offer->book_now_url))
    <a href="{{ $offer->book_now_url }}" target="_blank" rel="noopener"
       class="{{ $bookBtnClass }} {{ $wrapperClass ?? '' }}{{ $fullWidth ? ' w-100 d-block text-center' : '' }}">{{ $bookNowText }}</a>
@endif
