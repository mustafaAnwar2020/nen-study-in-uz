@if($offer->hasConfiguredMoreDetails())
    <a href="{{ $offer->more_details_url }}" target="_blank" rel="noopener"
       class="{{ $linkClass ?? 'btn btn-link btn-sm text-muted text-decoration-underline px-0' }}{{ !empty($fullWidth) ? ' w-100 d-block text-center' : '' }}">{{ $offer->more_details_text }}</a>
@endif
