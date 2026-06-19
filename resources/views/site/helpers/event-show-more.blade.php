@php
    /** @var \App\Models\Event $event */
    $buttonClass = $buttonClass ?? 'btn btn-custom-dark';
@endphp
@if($event->hasLandingPage())
    <a href="{{ $event->getLandingPageUrl() }}"
       class="{{ $buttonClass }} text-decoration-none"
       @if(!empty($stopPropagation)) onclick="event.stopPropagation();" @endif>
        Show more
    </a>
@else
    <button type="button"
            class="{{ $buttonClass }}"
            @if(!empty($stopPropagation)) onclick="event.stopPropagation(); showEventDetails(this, '{{ $event->id }}');" @else onclick="showEventDetails(this, '{{ $event->id }}')" @endif>
        Show more
    </button>
@endif
