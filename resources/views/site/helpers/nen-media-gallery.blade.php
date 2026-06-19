@if(collect($mediaGallery ?? [])->filter()->isNotEmpty())
<section class="nen-media" id="media">
    <div class="nen-landing__container">

        <div class="nen-media__header">
            <div>
                <div class="nen-media__eyebrow">Media</div>
                <h2 class="nen-media__title">{{ $landing->media_title }}</h2>
            </div>
            @if($landing->media_view_all_url ?? null)
                <a href="{{ $landing->media_view_all_url }}" class="nen-media__view-all">
                    View all
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            @endif
        </div>

        @php
            $slots = [
                'left_top'     => 'nen-media__item--left-top',
                'left_bottom'  => 'nen-media__item--left-bottom',
                'center'       => 'nen-media__item--center',
                'right_top'    => 'nen-media__item--right-top',
                'right_bottom' => 'nen-media__item--right-bottom',
            ];
            $visibleMediaCount = collect($mediaGallery ?? [])->filter(fn ($item) => $item && $item->image)->count();
        @endphp

        <div class="nen-media__grid" role="list" aria-label="Media gallery">
            @foreach($slots as $slot => $class)
                @if(!empty($mediaGallery[$slot]) && $mediaGallery[$slot]->image)
                    @php $item = $mediaGallery[$slot]; @endphp
                    <div
                        class="nen-media__item {{ $class }}"
                        role="listitem"
                        tabindex="0"
                        aria-label="{{ $item->caption ?: 'Gallery image' }}"
                        data-bs-toggle="modal"
                        data-bs-target="#imageModal"
                    >
                        <img
                            src="{{ asset($item->image) }}"
                            alt="{{ $item->caption ?: 'Media gallery image' }}"
                            class="clickable-image"
                            loading="lazy"
                        >

                        <span class="nen-media__zoom" aria-hidden="true">
                            <svg
                                width="{{ $slot === 'center' ? 18 : 14 }}"
                                height="{{ $slot === 'center' ? 18 : 14 }}"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/>
                            </svg>
                        </span>

                        @if($item->caption)
                            <span class="nen-media__caption">{{ $item->caption }}</span>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>

        @if(($mediaTotalCount ?? 0) > 0)
            <div class="nen-media__footer" aria-hidden="true">
                <span class="nen-media__footer-dot nen-media__footer-dot--active"></span>
                <span class="nen-media__footer-dot"></span>
                <span class="nen-media__footer-dot"></span>
                <span class="nen-media__footer-count">
                    {{ $visibleMediaCount }} of {{ $mediaTotalCount }} photos
                </span>
            </div>
        @endif

    </div>
</section>
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.nen-media__item').forEach(function (item) {
            item.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    var img = item.querySelector('.clickable-image');
                    if (img) {
                        img.click();
                    }
                }
            });
        });
    });
</script>
@endpush
