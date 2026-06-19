@php
    $agendaContent = $agenda ?? [];
    $agendaItems = data_get($agendaContent, 'items', []);
    $defaultIcons = ['bi-cup-hot', 'bi-easel', 'bi-globe', 'bi-airplane', 'bi-building', 'bi-person', 'bi-gift', 'bi-mic'];
    $agendaIconOptions = config('landing_bootstrap_icons.agenda', []);
@endphp
<div class="col-md-12 mt-3">
    <hr>
    <span class="badge badge-info">Section: agenda</span>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="landing_agenda_section_label">Section heading</label>
        <input id="landing_agenda_section_label" class="form-control" name="landing_agenda_section_label"
               placeholder="e.g. AGENDA"
               value="{{ old('landing_agenda_section_label', data_get($agendaContent, 'section_label')) }}">
    </div>
</div>

<div class="col-md-12">
    <input type="hidden" name="landing_agenda_json" id="landing_agenda_json"
           value='{{ old('landing_agenda_json', json_encode($agendaItems)) }}'>

    <div id="landing_agenda_container" class="row">
        @foreach($agendaItems as $index => $item)
            <div class="col-md-6 landing-agenda-row" data-index="{{ $index }}">
                <div class="card card-outline card-secondary mb-3">
                    <div class="card-header py-2 d-flex justify-content-between align-items-center">
                        <strong>Agenda item <span class="agenda-number">{{ $index + 1 }}</span></strong>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-agenda-btn">&times; Remove</button>
                    </div>
                    <div class="card-body py-3">
                        <div class="form-group">
                            <label>Time</label>
                            <input class="form-control agenda-time-input" placeholder="e.g. 08:30 - 09:00"
                                   value="{{ data_get($item, 'time') }}">
                        </div>
                        <div class="form-group">
                            <label>Session title</label>
                            <input class="form-control agenda-title-input"
                                   value="{{ data_get($item, 'title') }}">
                        </div>
                        @include('admin.partials.bootstrap-icon-select', [
                            'id' => 'landing_agenda_icon_' . $index,
                            'selected' => data_get($item, 'icon', $defaultIcons[$index] ?? 'bi-clock'),
                            'options' => $agendaIconOptions,
                            'selectClass' => 'agenda-icon-select',
                            'label' => 'Icon',
                        ])
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button type="button" class="btn btn-sm btn-outline-primary mb-3" id="add_agenda_btn">
        + Add Agenda Item
    </button>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var container = document.getElementById('landing_agenda_container');
        var jsonInput = document.getElementById('landing_agenda_json');
        var addBtn = document.getElementById('add_agenda_btn');
        var agendaIconOptions = @json($agendaIconOptions);

        function collect() {
            var rows = container.querySelectorAll('.landing-agenda-row');
            var items = [];
            rows.forEach(function (row) {
                items.push({
                    time: row.querySelector('.agenda-time-input')?.value || '',
                    title: row.querySelector('.agenda-title-input')?.value || '',
                    icon: row.querySelector('.agenda-icon-select')?.value || 'bi-clock',
                });
            });
            jsonInput.value = JSON.stringify(items);
        }

        function renumber() {
            var rows = container.querySelectorAll('.landing-agenda-row');
            rows.forEach(function (row, idx) {
                row.dataset.index = idx;
                row.querySelector('.agenda-number').textContent = idx + 1;
            });
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        }

        function createRow(index, data) {
            data = data || { time: '', title: '', icon: 'bi-clock' };
            var col = document.createElement('div');
            col.className = 'col-md-6 landing-agenda-row';
            col.dataset.index = index;

            var iconHtml = '';
            if (window.bootstrapIconSelect) {
                iconHtml = window.bootstrapIconSelect.buildControlHtml({
                    options: agendaIconOptions,
                    selected: data.icon || 'bi-clock',
                    selectClass: 'agenda-icon-select bootstrap-icon-select__input',
                    selectId: 'landing_agenda_icon_dyn_' + index,
                    label: 'Icon',
                });
            }

            col.innerHTML =
                '<div class="card card-outline card-secondary mb-3">' +
                    '<div class="card-header py-2 d-flex justify-content-between align-items-center">' +
                        '<strong>Agenda item <span class="agenda-number">' + (index + 1) + '</span></strong>' +
                        '<button type="button" class="btn btn-sm btn-outline-danger remove-agenda-btn">&times; Remove</button>' +
                    '</div>' +
                    '<div class="card-body py-3">' +
                        '<div class="form-group"><label>Time</label><input class="form-control agenda-time-input" placeholder="e.g. 08:30 - 09:00" value="' + escapeHtml(data.time) + '"></div>' +
                        '<div class="form-group"><label>Session title</label><input class="form-control agenda-title-input" value="' + escapeHtml(data.title) + '"></div>' +
                        iconHtml +
                    '</div>' +
                '</div>';

            if (window.bootstrapIconSelect) {
                var select = col.querySelector('.agenda-icon-select');
                if (select) window.bootstrapIconSelect.updatePreview(select);
            }

            return col;
        }

        addBtn.addEventListener('click', function () {
            var count = container.querySelectorAll('.landing-agenda-row').length;
            container.appendChild(createRow(count, { time: '', title: '', icon: 'bi-clock' }));
            attachRemove(document.querySelectorAll('.remove-agenda-btn'));
            collect();
        });

        function attachRemove(btns) {
            btns.forEach(function (btn) {
                if (btn.dataset.agendaRemoveBound) return;
                btn.dataset.agendaRemoveBound = '1';
                btn.addEventListener('click', function () {
                    if (confirm('Remove this agenda item?')) {
                        btn.closest('.landing-agenda-row').remove();
                        renumber();
                        collect();
                    }
                });
            });
        }

        attachRemove(document.querySelectorAll('.remove-agenda-btn'));
        container.addEventListener('change', function () { collect(); });
        container.addEventListener('input', function () { collect(); });

        if (window.bootstrapIconSelect) {
            window.bootstrapIconSelect.initAll(container);
        }

        var form = addBtn.closest('form');
        if (form) form.addEventListener('submit', function () { collect(); });
    });
</script>
@endpush
