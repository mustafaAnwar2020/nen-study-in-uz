<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
        <div class="modal-content bg-transparent border-0 shadow-none position-relative">
            <h2 id="imageModalTitle" class="visually-hidden">{{ __('Enlarged image') }}</h2>
            <button type="button" class="image-modal__close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}">
                <i class="bi bi-x-lg" aria-hidden="true"></i>
            </button>
            <div class="modal-body p-2 p-sm-3 text-center d-flex align-items-center justify-content-center">
                <img id="modalImage" src="" alt="" class="img-fluid rounded" style="max-height: min(88vh, 100%); width: auto; object-fit: contain;">
            </div>
        </div>
    </div>
</div>
