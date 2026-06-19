@php
    use App\Services\EventLandingPageService;
    $faqContent = $landingFaq ?? [];
    $faqItems = data_get($faqContent, 'items', []);
@endphp
<div class="col-md-12 mt-3">
    <hr>
    <span class="badge badge-info">Section: frequently asked questions</span>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="landing_faq_section_label">Section heading</label>
        <input id="landing_faq_section_label" class="form-control" name="landing_faq_section_label"
               placeholder="e.g. FREQUENTLY ASKED QUESTIONS"
               value="{{ old('landing_faq_section_label', data_get($faqContent, 'section_label')) }}">
    </div>
</div>

<div class="col-md-12">
    <input type="hidden" name="landing_faq_json" id="landing_faq_json"
           value='{{ old('landing_faq_json', json_encode($faqItems)) }}'>

    <div id="landing_faq_container" class="row">
        @foreach($faqItems as $index => $item)
            <div class="col-md-6 landing-faq-row" data-index="{{ $index }}">
                <div class="card card-outline card-secondary mb-3">
                    <div class="card-header py-2 d-flex justify-content-between align-items-center">
                        <strong>FAQ <span class="faq-number">{{ $index + 1 }}</span></strong>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-faq-btn">&times; Remove</button>
                    </div>
                    <div class="card-body py-3">
                        <div class="form-group">
                            <label>Question</label>
                            <input class="form-control faq-question-input"
                                   value="{{ data_get($item, 'question') }}">
                        </div>
                        <div class="form-group mb-0">
                            <label>Answer</label>
                            <textarea class="form-control faq-answer-input" rows="3">{{ data_get($item, 'answer') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button type="button" class="btn btn-sm btn-outline-primary mb-3" id="add_faq_btn">
        + Add FAQ
    </button>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var container = document.getElementById('landing_faq_container');
        var jsonInput = document.getElementById('landing_faq_json');
        var addBtn = document.getElementById('add_faq_btn');

        function collect() {
            var rows = container.querySelectorAll('.landing-faq-row');
            var items = [];
            rows.forEach(function (row) {
                items.push({
                    question: row.querySelector('.faq-question-input')?.value || '',
                    answer: row.querySelector('.faq-answer-input')?.value || '',
                });
            });
            jsonInput.value = JSON.stringify(items);
        }

        function renumber() {
            var rows = container.querySelectorAll('.landing-faq-row');
            rows.forEach(function (row, idx) {
                row.dataset.index = idx;
                row.querySelector('.faq-number').textContent = idx + 1;
            });
        }

        function createRow(index, data) {
            data = data || { question: '', answer: '' };
            var col = document.createElement('div');
            col.className = 'col-md-6 landing-faq-row';
            col.dataset.index = index;
            col.innerHTML =
                '<div class="card card-outline card-secondary mb-3">' +
                    '<div class="card-header py-2 d-flex justify-content-between align-items-center">' +
                        '<strong>FAQ <span class="faq-number">' + (index + 1) + '</span></strong>' +
                        '<button type="button" class="btn btn-sm btn-outline-danger remove-faq-btn">&times; Remove</button>' +
                    '</div>' +
                    '<div class="card-body py-3">' +
                        '<div class="form-group"><label>Question</label><input class="form-control faq-question-input" value="' + escapeHtml(data.question) + '"></div>' +
                        '<div class="form-group mb-0"><label>Answer</label><textarea class="form-control faq-answer-input" rows="3">' + escapeHtml(data.answer) + '</textarea></div>' +
                    '</div>' +
                '</div>';
            return col;
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        }

        addBtn.addEventListener('click', function () {
            var count = container.querySelectorAll('.landing-faq-row').length;
            container.appendChild(createRow(count, { question: '', answer: '' }));
            attachRemove(document.querySelectorAll('.remove-faq-btn'));
            collect();
        });

        function attachRemove(btns) {
            btns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    if (confirm('Remove this FAQ?')) {
                        btn.closest('.landing-faq-row').remove();
                        renumber();
                        collect();
                    }
                });
            });
        }

        attachRemove(document.querySelectorAll('.remove-faq-btn'));
        container.addEventListener('input', function () { collect(); });

        var form = addBtn.closest('form');
        if (form) form.addEventListener('submit', function () { collect(); });
    });
</script>
@endpush
