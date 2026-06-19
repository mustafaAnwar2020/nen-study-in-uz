@php
    $selectId = $id ?? ('bootstrap-icon-select-' . uniqid());
    $selectedValue = (string) ($selected ?? '');
    $options = $options ?? [];
    $selectClass = trim(($selectClass ?? '') . ' bootstrap-icon-select__input');
    $labelText = $label ?? 'Icon';
    $previewIconClass = $selectedValue !== '' ? $selectedValue : ($emptyPreviewClass ?? 'bi-dash-lg');
    $showSavedFallback = $showSavedFallback ?? true;
@endphp

@once
    @push('push_styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <style>
            .bootstrap-icon-select__control .input-group-text {
                min-width: 2.75rem;
                justify-content: center;
                background: #f8f9fa;
            }

            .bootstrap-icon-select__preview {
                font-size: 1.25rem;
                line-height: 1;
                color: #8a0c0f;
            }

            .bootstrap-icon-select__preview--empty {
                color: #adb5bd;
            }

            .bootstrap-icon-select__input {
                flex: 1 1 auto;
                min-width: 0;
            }
        </style>
    @endpush
    @push('scripts')
        <script>
            (function () {
                function normalizeBiClass(value) {
                    if (!value) return '';
                    var icon = String(value).trim().replace(/^bi\s+/, '');
                    if (!icon) return '';
                    return icon.indexOf('bi-') === 0 ? icon : 'bi-' + icon.replace(/^-+/, '');
                }

                function updateBootstrapIconSelectPreview(select) {
                    var wrap = select.closest('[data-component="bootstrap-icon-select"]');
                    if (!wrap) return;
                    var preview = wrap.querySelector('[data-role="preview"]');
                    if (!preview) return;
                    var icon = normalizeBiClass(select.value);
                    preview.className = 'bi ' + (icon || (select.dataset.emptyPreview || 'bi-dash-lg'));
                    preview.classList.toggle('bootstrap-icon-select__preview--empty', !icon);
                }

                function optionsToHtml(options, selected) {
                    var html = '';
                    Object.keys(options).forEach(function (val) {
                        var label = options[val];
                        var sel = String(val) === String(selected) ? ' selected' : '';
                        html += '<option value="' + String(val).replace(/"/g, '&quot;') + '"' + sel + '>' + label + '</option>';
                    });
                    if (selected && !Object.prototype.hasOwnProperty.call(options, selected)) {
                        html += '<option value="' + String(selected).replace(/"/g, '&quot;') + '" selected>' + selected + ' (saved)</option>';
                    }
                    return html;
                }

                window.bootstrapIconSelect = {
                    normalizeBiClass: normalizeBiClass,
                    optionsToHtml: optionsToHtml,
                    updatePreview: updateBootstrapIconSelectPreview,
                    initAll: function (root) {
                        (root || document).querySelectorAll('.bootstrap-icon-select__input').forEach(updateBootstrapIconSelectPreview);
                    },
                    buildControlHtml: function (opts) {
                        opts = opts || {};
                        var options = opts.options || {};
                        var selected = opts.selected || 'bi-clock';
                        var selectClass = opts.selectClass || 'bootstrap-icon-select__input';
                        var selectId = opts.selectId || '';
                        var label = opts.label || 'Icon';
                        var previewClass = normalizeBiClass(selected) || (opts.emptyPreview || 'bi-dash-lg');
                        var idAttr = selectId ? ' id="' + selectId.replace(/"/g, '&quot;') + '"' : '';
                        return '<div class="form-group mb-0 bootstrap-icon-select" data-component="bootstrap-icon-select">' +
                            '<label>' + label + '</label>' +
                            '<div class="input-group bootstrap-icon-select__control">' +
                            '<div class="input-group-prepend">' +
                            '<span class="input-group-text bootstrap-icon-select__preview' + (previewClass === (opts.emptyPreview || 'bi-dash-lg') && !selected ? ' bootstrap-icon-select__preview--empty' : '') + '">' +
                            '<i class="bi ' + previewClass + '" data-role="preview"></i></span></div>' +
                            '<select class="form-control ' + selectClass + '"' + idAttr + ' data-empty-preview="' + (opts.emptyPreview || 'bi-dash-lg') + '">' +
                            optionsToHtml(options, selected) + '</select></div></div>';
                    }
                };

                document.addEventListener('change', function (e) {
                    if (e.target.matches('.bootstrap-icon-select__input')) {
                        updateBootstrapIconSelectPreview(e.target);
                    }
                });

                document.addEventListener('DOMContentLoaded', function () {
                    window.bootstrapIconSelect.initAll();
                });
            })();
        </script>
    @endpush
@endonce

<div class="bootstrap-icon-select mb-0" data-component="bootstrap-icon-select">
    @if($labelText)
        <label for="{{ $selectId }}">{{ $labelText }}</label>
    @endif
    <div class="input-group bootstrap-icon-select__control">
        <div class="input-group-prepend">
            <span class="input-group-text bootstrap-icon-select__preview{{ $selectedValue === '' ? ' bootstrap-icon-select__preview--empty' : '' }}">
                <i class="bi {{ $previewIconClass }}" data-role="preview" aria-hidden="true"></i>
            </span>
        </div>
        <select id="{{ $selectId }}"
                class="form-control {{ $selectClass }}"
                @if(!empty($name)) name="{{ $name }}" @endif
                @if($selectedValue === '') data-empty-preview="{{ $emptyPreviewClass ?? 'bi-dash-lg' }}" @endif>
            @foreach($options as $iconValue => $iconLabel)
                <option value="{{ $iconValue }}" {{ (string) $selectedValue === (string) $iconValue ? 'selected' : '' }}>
                    {{ $iconLabel }}
                </option>
            @endforeach
            @if($showSavedFallback && $selectedValue !== '' && !array_key_exists($selectedValue, $options))
                <option value="{{ $selectedValue }}" selected>{{ $selectedValue }} (saved)</option>
            @endif
        </select>
    </div>
</div>
