@php
    use App\Services\EventLandingPageService;
    $speakersContent = $speakers ?? [];
    $speakerItems = data_get($speakersContent, 'speakers', []);
@endphp
<div class="col-md-12 mt-3">
    <hr>
    <span class="badge badge-info">Section: meet our speakers</span>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="landing_speakers_label">Section heading</label>
        <input id="landing_speakers_label" class="form-control" name="landing_speakers_label"
               placeholder="e.g. MEET OUR SPEAKERS"
               value="{{ old('landing_speakers_label', data_get($speakersContent, 'section_label')) }}">
    </div>
</div>

<div class="col-md-12">
    {{-- Hidden JSON input for all speakers --}}
    <input type="hidden" name="landing_speakers_json" id="landing_speakers_json"
           value='{{ old('landing_speakers_json', json_encode($speakerItems)) }}'>

    <div id="landing_speakers_container">
        @foreach($speakerItems as $index => $speaker)
            <div class="card card-outline card-secondary mb-3 landing-speaker-row" data-index="{{ $index }}">
                <div class="card-header py-2 d-flex justify-content-between align-items-center">
                    <strong>Speaker <span class="speaker-number">{{ $index + 1 }}</span></strong>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-speaker-btn">&times; Remove</button>
                </div>
                <div class="card-body py-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Photo</label>
                                @if(data_get($speaker, 'photo'))
                                    <a href="{{ asset(data_get($speaker, 'photo')) }}" target="_blank" class="d-block mb-1">show</a>
                                @endif
                                <x-file-upload class="form-control" data-folder="events" name="landing_speaker_{{ $index }}_photo-file"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Organization logo</label>
                                @if(data_get($speaker, 'org_logo'))
                                    <a href="{{ asset(data_get($speaker, 'org_logo')) }}" target="_blank" class="d-block mb-1">show</a>
                                @endif
                                <x-file-upload class="form-control" data-folder="events" name="landing_speaker_{{ $index }}_org_logo-file"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="speaker_name_{{ $index }}">Name</label>
                                <input id="speaker_name_{{ $index }}" class="form-control speaker-name-input"
                                       placeholder="Speaker name"
                                       value="{{ data_get($speaker, 'name') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="speaker_title_{{ $index }}">Title / role</label>
                                <input id="speaker_title_{{ $index }}" class="form-control speaker-title-input"
                                       value="{{ data_get($speaker, 'title') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label for="speaker_org_{{ $index }}">Organization</label>
                                <input id="speaker_org_{{ $index }}" class="form-control speaker-org-input"
                                       value="{{ data_get($speaker, 'organization') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button type="button" class="btn btn-sm btn-outline-primary mb-3" id="add_speaker_btn">
        + Add Speaker
    </button>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var speakersContainer = document.getElementById('landing_speakers_container');
        var speakersJsonInput = document.getElementById('landing_speakers_json');
        var addBtn = document.getElementById('add_speaker_btn');

        function collectSpeakers() {
            var rows = speakersContainer.querySelectorAll('.landing-speaker-row');
            var speakers = [];
            rows.forEach(function (row) {
                speakers.push({
                    name: row.querySelector('.speaker-name-input')?.value || '',
                    title: row.querySelector('.speaker-title-input')?.value || '',
                    organization: row.querySelector('.speaker-org-input')?.value || '',
                    photo: '',
                    org_logo: '',
                });
            });
            speakersJsonInput.value = JSON.stringify(speakers);
        }

        function renumber() {
            var rows = speakersContainer.querySelectorAll('.landing-speaker-row');
            rows.forEach(function (row, idx) {
                row.dataset.index = idx;
                row.querySelector('.speaker-number').textContent = idx + 1;
                // Update file input names
                var fileInputs = row.querySelectorAll('x-file-upload');
                // x-file-upload is a custom component — re-render needed, handled via name attributes
            });
        }

        function createSpeakerRow(index, data) {
            data = data || { name: '', title: '', organization: '' };
            var div = document.createElement('div');
            div.className = 'card card-outline card-secondary mb-3 landing-speaker-row';
            div.dataset.index = index;
            div.innerHTML =
                '<div class="card-header py-2 d-flex justify-content-between align-items-center">' +
                    '<strong>Speaker <span class="speaker-number">' + (index + 1) + '</span></strong>' +
                    '<button type="button" class="btn btn-sm btn-outline-danger remove-speaker-btn">&times; Remove</button>' +
                '</div>' +
                '<div class="card-body py-3"><div class="row">' +
                    '<div class="col-md-4"><div class="form-group"><label>Photo</label><x-file-upload class="form-control" data-folder="events" name="landing_speaker_' + index + '_photo-file"/></div></div>' +
                    '<div class="col-md-4"><div class="form-group"><label>Organization logo</label><x-file-upload class="form-control" data-folder="events" name="landing_speaker_' + index + '_org_logo-file"/></div></div>' +
                    '<div class="col-md-4"><div class="form-group"><label>Name</label><input class="form-control speaker-name-input" value="' + escapeHtml(data.name) + '"></div></div>' +
                    '<div class="col-md-6"><div class="form-group"><label>Title / role</label><input class="form-control speaker-title-input" value="' + escapeHtml(data.title) + '"></div></div>' +
                    '<div class="col-md-6"><div class="form-group mb-0"><label>Organization</label><input class="form-control speaker-org-input" value="' + escapeHtml(data.organization || '') + '"></div></div>' +
                '</div></div>';
            return div;
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        }

        // Add new speaker
        addBtn.addEventListener('click', function () {
            var count = speakersContainer.querySelectorAll('.landing-speaker-row').length;
            var row = createSpeakerRow(count, { name: '', title: '', organization: '' });
            speakersContainer.appendChild(row);
            attachRemoveHandler(row.querySelector('.remove-speaker-btn'));
            collectSpeakers();
        });

        function attachRemoveHandler(btn) {
            btn.addEventListener('click', function () {
                if (confirm('Remove this speaker?')) {
                    btn.closest('.landing-speaker-row').remove();
                    renumber();
                    collectSpeakers();
                }
            });
        }

        // Attach to existing remove buttons
        document.querySelectorAll('.remove-speaker-btn').forEach(attachRemoveHandler);

        // Collect on any input change
        speakersContainer.addEventListener('input', function () {
            collectSpeakers();
        });

        // Also persist when form submits
        var form = addBtn.closest('form');
        if (form) {
            form.addEventListener('submit', function () {
                collectSpeakers();
            });
        }
    });
</script>
@endpush
