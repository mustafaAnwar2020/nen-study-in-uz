<div class="offer-site-media__pdf-panel">
    <i class="bi bi-file-earmark-pdf offer-site-media__pdf-icon" aria-hidden="true"></i>
    <p class="offer-site-media__pdf-title">Event PDF</p>
    <div class="offer-site-media__pdf-actions">
        <button type="button"
                class="btn btn-sm btn-dark event-pdf-preview-btn"
                data-pdf-url="{{ $pdfUrl }}"
                aria-label="Preview PDF in this panel">
            Preview PDF
        </button>
        <a href="{{ $pdfUrl }}"
           class="btn btn-sm btn-outline-secondary offer-site-media__pdf-download"
           download="{{ $pdfDownloadName }}"
           rel="noopener">Download PDF</a>
        <a href="{{ $pdfUrl }}"
           class="btn btn-sm btn-outline-secondary offer-site-media__pdf-open"
           target="_blank"
           rel="noopener">Open in new tab</a>
    </div>
    <div class="event-pdf-preview-frame offer-site-media__pdf-embed" hidden></div>
</div>
