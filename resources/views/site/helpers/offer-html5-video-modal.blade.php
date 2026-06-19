{{-- HTML5 offer videos (not YouTube); #videoModal on the index is iframe-only --}}
<div class="modal fade" id="offerHtml5VideoModal" tabindex="-1" aria-labelledby="offerHtml5VideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered offer-html5-video-modal__dialog">
        <div class="modal-content bg-dark text-light border-0">
            <div class="modal-header border-secondary border-opacity-25 py-2 flex-shrink-0">
                <h2 class="modal-title h6 mb-0 pe-2 text-truncate" id="offerHtml5VideoModalLabel">{{ __('Video') }}</h2>
                <button type="button" class="btn-close btn-close-white flex-shrink-0" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>
            <div class="modal-body p-0 bg-black offer-html5-video-modal__body">
                <video id="offerHtml5VideoModalPlayer" controls playsinline preload="metadata"></video>
            </div>
        </div>
    </div>
</div>
