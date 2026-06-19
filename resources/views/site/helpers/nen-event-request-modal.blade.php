<div class="modal fade nen-event-request-modal" id="nenEventRequestModal" tabindex="-1" aria-labelledby="nenEventRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content nen-event-request-modal__content">
            <div class="modal-header nen-event-request-modal__header">
                <h5 class="modal-title" id="nenEventRequestModalLabel">Request this event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('site.event-request') }}" id="nenEventRequestForm">
                @csrf
                <div class="modal-body nen-event-request-modal__body">
                    @if($errors->any() && old('_form') === 'event_request')
                        <div class="nen-event-request-modal__alert nen-event-request-modal__alert--error">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <p class="nen-event-request-modal__event" id="nenEventRequestEventName" hidden></p>
                    <p class="nen-event-request-modal__intro" id="nenEventRequestIntro">
                        Select an archived event and tell us about your request. Our team will review it and get back to you.
                    </p>
                    <input type="hidden" name="_form" value="event_request">
                    <input type="hidden" name="event_id" id="nenEventRequestEventId"
                           value="{{ old('_form') === 'event_request' ? old('event_id') : '' }}" required>
                    <input type="hidden" name="event_title" id="nenEventRequestEventTitle"
                           value="{{ old('_form') === 'event_request' ? old('event_title') : '' }}">
                    <div class="nen-event-request-modal__field">
                        <label for="event_request_name">Name</label>
                        <input type="text" id="event_request_name" name="name" class="form-control"
                               value="{{ old('_form') === 'event_request' ? old('name') : '' }}" required>
                    </div>
                    <div class="nen-event-request-modal__field">
                        <label for="event_request_email">Email</label>
                        <input type="email" id="event_request_email" name="email" class="form-control"
                               value="{{ old('_form') === 'event_request' ? old('email') : '' }}" required>
                    </div>
                    <div class="nen-event-request-modal__field">
                        <label for="event_request_phone">Phone</label>
                        <input type="text" id="event_request_phone" name="phone" class="form-control"
                               value="{{ old('_form') === 'event_request' ? old('phone') : '' }}" required>
                    </div>
                    <div class="nen-event-request-modal__field">
                        <label for="event_request_notes">Notes</label>
                        <textarea id="event_request_notes" name="notes" class="form-control" rows="4"
                                  placeholder="Preferred dates, city, audience size, or other details…">{{ old('_form') === 'event_request' ? old('notes') : '' }}</textarea>
                    </div>
                </div>
                <div class="modal-footer nen-event-request-modal__footer">
                    <button type="button" class="nen-event-request-modal__btn nen-event-request-modal__btn--secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="nen-event-request-modal__btn nen-event-request-modal__btn--primary">Submit request</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openEventRequestModal(eventId, eventTitle) {
        var idInput = document.getElementById('nenEventRequestEventId');
        var titleInput = document.getElementById('nenEventRequestEventTitle');
        var nameEl = document.getElementById('nenEventRequestEventName');
        var introEl = document.getElementById('nenEventRequestIntro');
        var modalEl = document.getElementById('nenEventRequestModal');

        if (!idInput || !modalEl) return;

        idInput.value = eventId;
        if (titleInput) {
            titleInput.value = eventTitle || '';
        }
        if (nameEl && eventTitle) {
            nameEl.textContent = eventTitle;
            nameEl.hidden = false;
        }
        if (introEl) {
            introEl.textContent = 'Request details for this archived event. Our team will review your submission and contact you.';
        }

        if (typeof bootstrap !== 'undefined') {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.nen-archive-card__btn--request').forEach(function (btn) {
            btn.addEventListener('click', function () {
                openEventRequestModal(this.dataset.eventId, this.dataset.eventTitle);
            });
        });

        @if($errors->any() && old('_form') === 'event_request')
            var modalEl = document.getElementById('nenEventRequestModal');
            var eventTitle = @json(old('event_title'));
            if (eventTitle) {
                var nameEl = document.getElementById('nenEventRequestEventName');
                if (nameEl) {
                    nameEl.textContent = eventTitle;
                    nameEl.hidden = false;
                }
            }
            if (modalEl && typeof bootstrap !== 'undefined') {
                bootstrap.Modal.getOrCreateInstance(modalEl).show();
            }
        @endif
    });
</script>
@endpush
