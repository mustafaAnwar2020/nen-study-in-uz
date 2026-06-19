@php
    $partnersContent = $partners ?? [];
    $partnerItems = data_get($partnersContent, 'partners', []);
    $partnersJson = old('landing_partners_json');
    if (!is_string($partnersJson)) {
        $partnersJson = json_encode($partnerItems, JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT);
    }
@endphp
<div class="col-md-12 mt-3">
    <hr>
    <span class="badge badge-info">Section: partners</span>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="landing_partners_label">Section heading</label>
        <input id="landing_partners_label" class="form-control" name="landing_partners_label"
               placeholder="e.g. ORGANIZERS &amp; PARTNERS"
               value="{{ old('landing_partners_label', data_get($partnersContent, 'section_label')) }}">
    </div>
</div>

<div class="col-md-12">
    <input type="hidden" name="landing_partners_json" id="landing_partners_json"
           value="{{ $partnersJson }}">

    <div id="landing_partners_container" class="row">
        @foreach($partnerItems as $index => $partner)
            <div class="col-md-6 col-lg-4 landing-partner-row"
                 data-index="{{ $index }}"
                 data-logo="{{ data_get($partner, 'logo', '') }}">
                <div class="card card-outline card-secondary mb-3">
                    <div class="card-header py-2 d-flex justify-content-between align-items-center">
                        <strong>Partner <span class="partner-number">{{ $index + 1 }}</span></strong>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-partner-btn">&times; Remove</button>
                    </div>
                    <div class="card-body py-3">
                        <div class="form-group partner-logo-field">
                            <label>Logo</label>
                            @if(data_get($partner, 'logo'))
                                <a href="{{ asset(data_get($partner, 'logo')) }}" target="_blank" class="d-block mb-1">show</a>
                                <input type="hidden" class="partner-logo-path" name="landing_partner_{{ $index }}_logo" value="{{ data_get($partner, 'logo') }}">
                            @endif
                            <x-file-upload class="form-control" data-folder="events" name="landing_partner_{{ $index }}_logo-file"/>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control partner-name-input" placeholder="Optional for logo-only cards"
                                   value="{{ data_get($partner, 'name') }}">
                        </div>
                        <div class="form-group">
                            <label>Short info <small class="text-muted">(shown when visitors click the logo)</small></label>
                            <textarea class="form-control partner-info-input" rows="3" maxlength="1000"
                                      placeholder="e.g. Organization description...">{{ data_get($partner, 'info') }}</textarea>
                        </div>
                        <div class="form-group mb-0">
                            <label>Website <small class="text-muted">(optional)</small></label>
                            <input type="url" class="form-control partner-website-input" placeholder="https://www.example.org"
                                   value="{{ data_get($partner, 'website') }}">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button type="button" class="btn btn-sm btn-outline-primary mb-3" id="add_partner_btn">
        + Add Partner
    </button>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var container = document.getElementById('landing_partners_container');
        var jsonInput = document.getElementById('landing_partners_json');
        var addBtn = document.getElementById('add_partner_btn');
        if (!container || !jsonInput || !addBtn) {
            return;
        }

        function findLogoHidden(row) {
            return row.querySelector('input.partner-logo-path')
                || row.querySelector('input[type="hidden"][name^="landing_partner_"][name$="_logo"]');
        }

        function getRowLogo(row) {
            var hidden = findLogoHidden(row);
            if (hidden && hidden.value.trim()) {
                return hidden.value.trim();
            }
            return (row.dataset.logo || '').trim();
        }

        function ensureLogoHidden(row, idx, logoPath) {
            if (!logoPath) {
                return;
            }
            var hidden = row.querySelector('input.partner-logo-path');
            if (!hidden) {
                hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.className = 'partner-logo-path';
                hidden.name = 'landing_partner_' + idx + '_logo';
                var logoGroup = row.querySelector('.partner-logo-field');
                if (logoGroup) {
                    logoGroup.insertBefore(hidden, logoGroup.firstChild);
                }
            }
            hidden.name = 'landing_partner_' + idx + '_logo';
            hidden.value = logoPath;
            row.dataset.logo = logoPath;
        }

        function collect() {
            var rows = container.querySelectorAll('.landing-partner-row');
            var items = [];
            rows.forEach(function (row) {
                var nameInput = row.querySelector('.partner-name-input');
                var infoInput = row.querySelector('.partner-info-input');
                var websiteInput = row.querySelector('.partner-website-input');
                items.push({
                    name: nameInput ? nameInput.value.trim() : '',
                    logo: getRowLogo(row),
                    info: infoInput ? infoInput.value.trim() : '',
                    website: websiteInput ? websiteInput.value.trim() : '',
                });
            });
            jsonInput.value = JSON.stringify(items);
        }

        function renumber() {
            var rows = container.querySelectorAll('.landing-partner-row');
            rows.forEach(function (row, idx) {
                row.dataset.index = String(idx);
                var number = row.querySelector('.partner-number');
                if (number) {
                    number.textContent = String(idx + 1);
                }

                var logoHidden = findLogoHidden(row);
                if (logoHidden) {
                    logoHidden.className = 'partner-logo-path';
                    logoHidden.name = 'landing_partner_' + idx + '_logo';
                }

                var fileInput = row.querySelector('.uploader-container input[type="file"]');
                if (fileInput) {
                    fileInput.name = 'landing_partner_' + idx + '_logo-file';
                }
            });
        }

        function fileUploadHtml(index) {
            return '<small>Max Size: 5 MB</small>' +
                '<div class="uploader-container">' +
                    '<input type="file" class="form-control" data-folder="events" name="landing_partner_' + index + '_logo-file" accept=".jpg,.jpeg,.png,.gif,.bmp,.pdf,.xls,.xlsx">' +
                    '<progress class="progressBar progress__sec" value="0" max="100" style="width:100%;"></progress>' +
                    '<p class="status"></p>' +
                '</div>';
        }

        function createRow(index, data) {
            data = data || { name: '', logo: '', info: '', website: '' };
            var col = document.createElement('div');
            col.className = 'col-md-6 col-lg-4 landing-partner-row';
            col.dataset.index = String(index);
            col.dataset.logo = data.logo || '';

            var logoHidden = data.logo
                ? '<input type="hidden" class="partner-logo-path" name="landing_partner_' + index + '_logo" value="' + escapeAttr(data.logo) + '">'
                : '';

            col.innerHTML =
                '<div class="card card-outline card-secondary mb-3">' +
                    '<div class="card-header py-2 d-flex justify-content-between align-items-center">' +
                        '<strong>Partner <span class="partner-number">' + (index + 1) + '</span></strong>' +
                        '<button type="button" class="btn btn-sm btn-outline-danger remove-partner-btn">&times; Remove</button>' +
                    '</div>' +
                    '<div class="card-body py-3">' +
                        '<div class="form-group partner-logo-field"><label>Logo</label>' + logoHidden + fileUploadHtml(index) + '</div>' +
                        '<div class="form-group"><label>Name</label>' +
                            '<input class="form-control partner-name-input" placeholder="Optional for logo-only cards" value="' + escapeHtml(data.name || '') + '">' +
                        '</div>' +
                        '<div class="form-group"><label>Short info</label>' +
                            '<textarea class="form-control partner-info-input" rows="3" maxlength="1000" placeholder="Shown when visitors click the logo">' + escapeHtml(data.info || '') + '</textarea>' +
                        '</div>' +
                        '<div class="form-group mb-0"><label>Website</label>' +
                            '<input type="url" class="form-control partner-website-input" placeholder="https://www.example.org" value="' + escapeHtml(data.website || '') + '">' +
                        '</div>' +
                    '</div>' +
                '</div>';
            return col;
        }

        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function escapeAttr(str) {
            return escapeHtml(str).replace(/&#039;/g, '&#39;');
        }

        function initFileUploads() {
            if (typeof window.setupFileUploadHandler === 'function') {
                window.setupFileUploadHandler();
            }
        }

        addBtn.addEventListener('click', function () {
            var count = container.querySelectorAll('.landing-partner-row').length;
            var row = createRow(count, { name: '', logo: '', info: '', website: '' });
            container.appendChild(row);
            initFileUploads();
            renumber();
            collect();
        });

        container.addEventListener('click', function (event) {
            var btn = event.target.closest('.remove-partner-btn');
            if (!btn || !container.contains(btn)) {
                return;
            }
            event.preventDefault();
            if (!confirm('Remove this partner?')) {
                return;
            }
            var row = btn.closest('.landing-partner-row');
            if (row) {
                row.remove();
            }
            renumber();
            collect();
        });

        container.addEventListener('input', collect);
        container.addEventListener('change', function (event) {
            if (event.target.matches('input.partner-logo-path')) {
                var row = event.target.closest('.landing-partner-row');
                if (row) {
                    row.dataset.logo = event.target.value.trim();
                }
                collect();
            }
        });

        function syncRowsFromJson() {
            var items = [];
            try {
                items = JSON.parse(jsonInput.value || '[]');
            } catch (error) {
                items = [];
            }
            if (!Array.isArray(items)) {
                return;
            }
            var rows = container.querySelectorAll('.landing-partner-row');
            rows.forEach(function (row, idx) {
                var item = items[idx] || {};
                if (item.logo && !getRowLogo(row)) {
                    ensureLogoHidden(row, idx, item.logo);
                }
                var infoInput = row.querySelector('.partner-info-input');
                var websiteInput = row.querySelector('.partner-website-input');
                if (infoInput && item.info && !infoInput.value) {
                    infoInput.value = item.info;
                }
                if (websiteInput && item.website && !websiteInput.value) {
                    websiteInput.value = item.website;
                }
            });
        }

        var form = document.getElementById('form');
        if (form) {
            form.addEventListener('submit', function () {
                collect();
            }, true);
        }

        syncRowsFromJson();
    });
</script>
@endpush
