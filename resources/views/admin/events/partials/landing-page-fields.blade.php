@php
    $hero = $hero ?? [];
    $landingEnabled = !empty($row) && $row->hasLandingPage();
@endphp
<div class="col-md-12">
    <hr>
    <h4 class="mb-3">Event landing page</h4>
    <p class="text-muted small">
        Landing content is stored in separate tables (<code>event_landing_pages</code> / <code>event_landing_sections</code>).
        Add new page sections later without new columns on <code>events</code>.
    </p>
    <p class="text-muted small">When enabled, &ldquo;Show more&rdquo; on the home page and events listing opens this dedicated page instead of the details popup.</p>
    @if(isset($row) && $row->slug)
        <p class="small mb-2">
            Public URL:
            <a href="{{ route('site.events.show', $row->slug) }}" target="_blank" rel="noopener">
                {{ route('site.events.show', $row->slug) }}
            </a>
            @if(!$landingEnabled)
                <span class="text-warning">(returns 404 until landing page is enabled)</span>
            @endif
        </p>
    @endif
</div>

<div class="col-md-3">
    <div class="form-group">
        <label class="form-label" for="has_landing_page">Enable landing page?</label><br>
        <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary mb-2">
            <input type="checkbox" value="1" name="has_landing_page" id="has_landing_page"
                    {{ $landingEnabled ? 'checked' : '' }}>
            <span class="mr-3"> </span>
        </label>
    </div>
</div>

<div class="col-md-12 landing-page-fields">
    <div class="row">
        <div class="col-md-12 mb-2">
            <span class="badge badge-info">Section: hero</span>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="landing_title">Hero title</label>
                <input id="landing_title" class="form-control" name="landing_title"
                       placeholder="e.g. ETS International Conference"
                       value="{{ old('landing_title', data_get($hero, 'title')) }}">
                <small class="text-muted">Leave empty to use the event name.</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="landing_title_highlight">Highlighted title part</label>
                <input id="landing_title_highlight" class="form-control" name="landing_title_highlight"
                       placeholder="e.g. Namangan"
                       value="{{ old('landing_title_highlight', data_get($hero, 'title_highlight')) }}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="landing_description">Hero description</label>
                <textarea id="landing_description" rows="3" class="form-control"
                          name="landing_description">{{ old('landing_description', data_get($hero, 'description')) }}</textarea>
                <small class="text-muted">Leave empty to use the main event description.</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="landing_date_label">Date label</label>
                <input id="landing_date_label" class="form-control" name="landing_date_label"
                       placeholder="e.g. 16 JUNE 2026, Tuesday"
                       value="{{ old('landing_date_label', data_get($hero, 'date_label')) }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="landing_time_label">Time label</label>
                <input id="landing_time_label" class="form-control" name="landing_time_label"
                       placeholder="e.g. 9:00 – 13:30 (GMT+5)"
                       value="{{ old('landing_time_label', data_get($hero, 'time_label')) }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="landing_location_label">Location label</label>
                <input id="landing_location_label" class="form-control" name="landing_location_label"
                       placeholder="e.g. MA'RIFAT MASKANI, Namangan"
                       value="{{ old('landing_location_label', data_get($hero, 'location_label')) }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="landing_hero_image">
                    Hero image
                    @if(data_get($hero, 'hero_image'))
                        <a href="{{ asset(data_get($hero, 'hero_image')) }}" target="_blank">show <i class="fa fa-eye"></i></a>
                    @endif
                </label>
                <x-file-upload class="form-control" data-folder="events" name="landing_hero_image-file"/>
                <small class="text-muted d-block">Falls back to the main event image if empty.</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="landing_qr_image">
                    QR code image
                    @if(data_get($hero, 'qr_image'))
                        <a href="{{ asset(data_get($hero, 'qr_image')) }}" target="_blank">show <i class="fa fa-eye"></i></a>
                    @endif
                </label>
                <x-file-upload class="form-control" data-folder="events" name="landing_qr_image-file"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="landing_register_label">Register button label</label>
                <input id="landing_register_label" class="form-control" name="landing_register_label"
                       placeholder="Register now"
                       value="{{ old('landing_register_label', data_get($hero, 'register_label')) }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="landing_agenda_label">Agenda button label</label>
                <input id="landing_agenda_label" class="form-control" name="landing_agenda_label"
                       placeholder="View agenda"
                       value="{{ old('landing_agenda_label', data_get($hero, 'agenda_label')) }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="landing_agenda_url">
                    Agenda PDF
                    @if(data_get($hero, 'agenda_url'))
                        <a href="{{ asset(data_get($hero, 'agenda_url')) }}" target="_blank">show <i class="fa fa-eye"></i></a>
                    @endif
                </label>
                <x-file-upload class="form-control" data-folder="events" name="landing_agenda_url-file"/>
                <small class="text-muted d-block">Upload a PDF agenda. Falls back to the event PDF if empty.</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="landing_countdown_at">Event starts (countdown)</label>
                @php
                    $countdownRaw = old('landing_countdown_at', data_get($hero, 'countdown_at'));
                    $countdownValue = $countdownRaw
                        ? \Illuminate\Support\Carbon::parse($countdownRaw)->format('Y-m-d\TH:i')
                        : '';
                @endphp
                <input id="landing_countdown_at" type="datetime-local" class="form-control" name="landing_countdown_at"
                       value="{{ $countdownValue }}">
                <small class="text-muted">Defaults to event date at midnight if empty.</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="landing_countdown_end_at">Event ends (countdown)</label>
                @php
                    $countdownEndRaw = old('landing_countdown_end_at', data_get($hero, 'countdown_end_at'));
                    $countdownEndValue = $countdownEndRaw
                        ? \Illuminate\Support\Carbon::parse($countdownEndRaw)->format('Y-m-d\TH:i')
                        : '';
                @endphp
                <input id="landing_countdown_end_at" type="datetime-local" class="form-control" name="landing_countdown_end_at"
                       value="{{ $countdownEndValue }}">
                <small class="text-muted">Optional. Parsed from time label (e.g. 9:00 - 14:00) if empty.</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="landing_whatsapp_url">WhatsApp URL</label>
                <input id="landing_whatsapp_url" class="form-control" name="landing_whatsapp_url"
                       value="{{ old('landing_whatsapp_url', data_get($hero, 'whatsapp_url')) }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="landing_telegram_url">Telegram URL</label>
                <input id="landing_telegram_url" class="form-control" name="landing_telegram_url"
                       value="{{ old('landing_telegram_url', data_get($hero, 'telegram_url')) }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="landing_faq_url">FAQ URL</label>
                <input id="landing_faq_url" class="form-control" name="landing_faq_url"
                       placeholder="{{ route('site.faqs') }}"
                       value="{{ old('landing_faq_url', data_get($hero, 'faq_url')) }}">
            </div>
        </div>

        @include('admin.events.partials.landing-about-reasons-fields', ['aboutReasons' => $aboutReasons ?? []])
        @include('admin.events.partials.landing-stats-fields', ['stats' => $stats ?? []])
        @include('admin.events.partials.landing-details-map-fields', ['detailsMap' => $detailsMap ?? []])
        @include('admin.events.partials.landing-speakers-fields', ['speakers' => $speakers ?? []])
        @include('admin.events.partials.landing-agenda-fields', ['agenda' => $agenda ?? []])
        @include('admin.events.partials.landing-organizers-fields', [
            'organizers' => $organizers ?? [],
            'mapLocations' => $mapLocations ?? collect(),
        ])
        @include('admin.events.partials.landing-partners-fields', ['partners' => $partners ?? []])
        @include('admin.events.partials.landing-faq-fields', ['landingFaq' => $landingFaq ?? []])
        @include('admin.events.partials.landing-media-fields', ['landingMedia' => $landingMedia ?? []])
    </div>
</div>

@push('scripts')
    <script>
        $(function () {
            function toggleLandingFields() {
                var on = $('#has_landing_page').is(':checked');
                $('.landing-page-fields').toggle(on);
            }
            toggleLandingFields();
            $(document).on('change', '#has_landing_page', toggleLandingFields);
        });
    </script>
@endpush
