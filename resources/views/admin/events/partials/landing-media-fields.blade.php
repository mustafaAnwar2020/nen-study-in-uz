@php
    $mediaContent = $landingMedia ?? [];
    $mediaItems = data_get($mediaContent, 'items', []);
    if (!is_array($mediaItems)) {
        $mediaItems = [];
    }
    $mediaJson = old('landing_media_json');
    if (!is_string($mediaJson)) {
        $mediaJson = json_encode($mediaItems, JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT);
    }
@endphp
<div class="col-md-12 mt-3">
    <hr>
    <span class="badge badge-info">Section: media (near footer)</span>
    <p class="text-muted small mb-0 mt-1">Images or YouTube videos shown above the landing page footer.</p>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="landing_media_section_label">Section heading</label>
        <input id="landing_media_section_label" class="form-control" name="landing_media_section_label"
               placeholder="e.g. Media"
               value="{{ old('landing_media_section_label', data_get($mediaContent, 'section_label')) }}">
    </div>
</div>

<div class="col-md-12">
    <input type="hidden" name="landing_media_json" id="landing_media_json" value='{{ $mediaJson }}'>

    <div id="landing_media_container" class="row">
        @foreach($mediaItems as $index => $item)
            @php
                $type = data_get($item, 'type') === 'video' ? 'video' : 'image';
                $file = data_get($item, 'file', '');
            @endphp
            <div class="col-md-6 col-lg-4 landing-media-row" data-index="{{ $index }}" data-file="{{ $file }}">
                <div class="card card-outline card-secondary mb-3">
                    <div class="card-header py-2 d-flex justify-content-between align-items-center">
                        <strong>Media <span class="media-number">{{ $index + 1 }}</span></strong>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-media-btn">&times; Remove</button>
                    </div>
                    <div class="card-body py-3">
                        <div class="form-group">
                            <label>Type</label>
                            <select class="form-control media-type-input">
                                <option value="image" {{ $type === 'image' ? 'selected' : '' }}>Image</option>
                                <option value="video" {{ $type === 'video' ? 'selected' : '' }}>Video (YouTube)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Title (optional)</label>
                            <input class="form-control media-title-input" value="{{ data_get($item, 'title') }}">
                        </div>
                        <div class="form-group media-url-field" style="{{ $type === 'video' ? '' : 'display:none' }}">
                            <label>YouTube URL</label>
                            <input class="form-control media-url-input" placeholder="https://www.youtube.com/watch?v=…"
                                   value="{{ data_get($item, 'url') }}">
                        </div>
                        <div class="form-group mb-0 media-file-field" style="{{ $type === 'image' ? '' : 'display:none' }}">
                            <label>
                                Image file
                                @if($file)
                                    <a href="{{ asset($file) }}" target="_blank" rel="noopener">show <i class="fa fa-eye"></i></a>
                                @endif
                            </label>
                            <div class="media-file-upload-wrap">
                                <x-file-upload class="form-control" data-folder="events" name="landing_media_{{ $index }}_file-file"/>
                            </div>
                            @if($file)
                                <input type="hidden" class="media-file-path" name="landing_media_{{ $index }}_file" value="{{ $file }}">
                            @endif
                            <small class="text-muted">JPG, PNG, GIF, or WebP. Max 5 MB.</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button type="button" class="btn btn-sm btn-outline-primary mb-3" id="add_media_btn">+ Add media item</button>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var container = document.getElementById('landing_media_container');
        var jsonInput = document.getElementById('landing_media_json');
        var addBtn = document.getElementById('add_media_btn');
        if (!container || !jsonInput) return;

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

        function getRowFile(row) {
            var hidden = row.querySelector('input.media-file-path');
            if (hidden && hidden.value.trim()) {
                return hidden.value.trim();
            }
            var uploadHidden = row.querySelector('.uploader-container input[type="hidden"][name^="landing_media_"][name$="_file"]');
            if (uploadHidden && uploadHidden.value.trim()) {
                return uploadHidden.value.trim();
            }
            return (row.dataset.file || '').trim();
        }

        function ensureFileHidden(row, idx, path) {
            if (!path) return;
            var hidden = row.querySelector('input.media-file-path');
            if (!hidden) {
                hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.className = 'media-file-path';
                var wrap = row.querySelector('.media-file-upload-wrap');
                if (wrap) {
                    wrap.insertBefore(hidden, wrap.firstChild);
                } else {
                    row.querySelector('.media-file-field')?.appendChild(hidden);
                }
            }
            hidden.name = 'landing_media_' + idx + '_file';
            hidden.value = path;
            row.dataset.file = path;
        }

        function syncTypeFields(row) {
            var type = row.querySelector('.media-type-input')?.value || 'image';
            var urlField = row.querySelector('.media-url-field');
            var fileField = row.querySelector('.media-file-field');
            if (urlField) {
                urlField.style.display = type === 'video' ? '' : 'none';
            }
            if (fileField) {
                fileField.style.display = type === 'image' ? '' : 'none';
            }
        }

        function collect() {
            var rows = container.querySelectorAll('.landing-media-row');
            var items = [];
            rows.forEach(function (row) {
                var type = row.querySelector('.media-type-input')?.value || 'image';
                items.push({
                    type: type,
                    title: (row.querySelector('.media-title-input')?.value || '').trim(),
                    url: type === 'video' ? (row.querySelector('.media-url-input')?.value || '').trim() : '',
                    file: type === 'image' ? getRowFile(row) : '',
                });
            });
            jsonInput.value = JSON.stringify(items);
        }

        function renumber() {
            var rows = container.querySelectorAll('.landing-media-row');
            rows.forEach(function (row, idx) {
                row.dataset.index = String(idx);
                row.querySelector('.media-number').textContent = String(idx + 1);

                var fileHidden = row.querySelector('input.media-file-path');
                if (fileHidden) {
                    fileHidden.name = 'landing_media_' + idx + '_file';
                }

                var fileInput = row.querySelector('.uploader-container input[type="file"]');
                if (fileInput) {
                    fileInput.name = 'landing_media_' + idx + '_file-file';
                }
            });
        }

        function fileUploadHtml(index) {
            return '<small>Max Size: 5 MB</small>' +
                '<div class="media-file-upload-wrap">' +
                    '<div class="uploader-container">' +
                        '<input type="file" class="form-control" data-folder="events" name="landing_media_' + index + '_file-file" accept=".jpg,.jpeg,.png,.gif,.webp,.bmp">' +
                        '<progress class="progressBar progress__sec" value="0" max="100" style="width:100%;"></progress>' +
                        '<p class="status"></p>' +
                    '</div>' +
                '</div>' +
                '<small class="text-muted">JPG, PNG, GIF, or WebP. Max 5 MB.</small>';
        }

        function createRow(index, data) {
            data = data || { type: 'image', title: '', url: '', file: '' };
            var col = document.createElement('div');
            col.className = 'col-md-6 col-lg-4 landing-media-row';
            col.dataset.index = String(index);
            col.dataset.file = data.file || '';

            var fileHidden = data.file
                ? '<input type="hidden" class="media-file-path" name="landing_media_' + index + '_file" value="' + escapeAttr(data.file) + '">'
                : '';

            col.innerHTML =
                '<div class="card card-outline card-secondary mb-3">' +
                    '<div class="card-header py-2 d-flex justify-content-between align-items-center">' +
                        '<strong>Media <span class="media-number">' + (index + 1) + '</span></strong>' +
                        '<button type="button" class="btn btn-sm btn-outline-danger remove-media-btn">&times; Remove</button>' +
                    '</div>' +
                    '<div class="card-body py-3">' +
                        '<div class="form-group"><label>Type</label>' +
                            '<select class="form-control media-type-input">' +
                                '<option value="image"' + (data.type !== 'video' ? ' selected' : '') + '>Image</option>' +
                                '<option value="video"' + (data.type === 'video' ? ' selected' : '') + '>Video (YouTube)</option>' +
                            '</select></div>' +
                        '<div class="form-group"><label>Title (optional)</label>' +
                            '<input class="form-control media-title-input" value="' + escapeHtml(data.title || '') + '"></div>' +
                        '<div class="form-group media-url-field" style="display:none"><label>YouTube URL</label>' +
                            '<input class="form-control media-url-input" placeholder="https://www.youtube.com/watch?v=…" value="' + escapeHtml(data.url || '') + '"></div>' +
                        '<div class="form-group mb-0 media-file-field"><label>Image file</label>' +
                            fileHidden + fileUploadHtml(index) +
                        '</div>' +
                    '</div>' +
                '</div>';
            syncTypeFields(col);
            return col;
        }

        function initFileUploads() {
            if (typeof window.setupFileUploadHandler === 'function') {
                window.setupFileUploadHandler();
            }
        }

        container.querySelectorAll('.landing-media-row').forEach(syncTypeFields);

        container.addEventListener('change', function (e) {
            if (e.target.classList.contains('media-type-input')) {
                syncTypeFields(e.target.closest('.landing-media-row'));
            }
            if (e.target.matches('input.media-file-path')) {
                var row = e.target.closest('.landing-media-row');
                if (row) {
                    row.dataset.file = e.target.value.trim();
                }
            }
            collect();
        });

        container.addEventListener('input', collect);

        container.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-media-btn')) {
                e.preventDefault();
                e.target.closest('.landing-media-row')?.remove();
                renumber();
                collect();
            }
        });

        addBtn.addEventListener('click', function () {
            var count = container.querySelectorAll('.landing-media-row').length;
            container.appendChild(createRow(count, { type: 'image', title: '', url: '', file: '' }));
            initFileUploads();
            renumber();
            collect();
        });

        function syncRowsFromJson() {
            var items = [];
            try {
                items = JSON.parse(jsonInput.value || '[]');
            } catch (err) {
                items = [];
            }
            if (!Array.isArray(items)) return;
            container.querySelectorAll('.landing-media-row').forEach(function (row, idx) {
                var item = items[idx] || {};
                if (item.file && !getRowFile(row)) {
                    ensureFileHidden(row, idx, item.file);
                }
            });
        }

        var form = document.getElementById('form');
        if (form) {
            form.addEventListener('submit', function () {
                collect();
            }, true);
        }

        initFileUploads();
        syncRowsFromJson();
        collect();
    });
</script>
@endpush
