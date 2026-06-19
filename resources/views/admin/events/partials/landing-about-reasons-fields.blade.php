@php
    $aboutReasons = $aboutReasons ?? [];
    $reasons = data_get($aboutReasons, 'reasons', []);
    $defaultIcons = ['bi-globe', 'bi-people-fill', 'bi-briefcase-fill'];
@endphp
<div class="col-md-12 mt-3">
    <hr>
    <span class="badge badge-info">Section: about &amp; reasons to join</span>
</div>

{{-- About section --}}
<div class="col-md-12">
    <h5 class="text-muted mt-2">About the Conference</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="landing_about_label">About label</label>
                <input id="landing_about_label" class="form-control" name="landing_about_label"
                       placeholder="e.g. About the Conference"
                       value="{{ old('landing_about_label', data_get($aboutReasons, 'about_label')) }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="landing_about_title">About heading</label>
                <input id="landing_about_title" class="form-control" name="landing_about_title"
                       placeholder="e.g. A Global Conversation Starts in Namangan"
                       value="{{ old('landing_about_title', data_get($aboutReasons, 'about_title')) }}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="landing_about_description">About text</label>
                <textarea id="landing_about_description" rows="5" class="form-control" name="landing_about_description"
                          placeholder="Use a blank line between paragraphs.">{{ old('landing_about_description', data_get($aboutReasons, 'about_description')) }}</textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="landing_about_images_main">
                    About image — main (large, right side)
                    @if(data_get($aboutReasons, 'about_images.main'))
                        <a href="{{ asset(data_get($aboutReasons, 'about_images.main')) }}" target="_blank">show <i class="fa fa-eye"></i></a>
                    @endif
                </label>
                <x-file-upload class="form-control" data-folder="events" name="landing_about_images_main-file"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="landing_about_images_secondary">
                    About image — secondary (small, left side)
                    @if(data_get($aboutReasons, 'about_images.secondary'))
                        <a href="{{ asset(data_get($aboutReasons, 'about_images.secondary')) }}" target="_blank">show <i class="fa fa-eye"></i></a>
                    @endif
                </label>
                <x-file-upload class="form-control" data-folder="events" name="landing_about_images_secondary-file"/>
            </div>
        </div>
    </div>
</div>

{{-- Reasons section --}}
<div class="col-md-12 mt-4">
    <h5 class="text-muted">Why This Conference — Reasons to Join</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="landing_reasons_label">Reasons eyebrow label</label>
                <input id="landing_reasons_label" class="form-control" name="landing_reasons_label"
                       placeholder="e.g. Why this conference"
                       value="{{ old('landing_reasons_label', data_get($aboutReasons, 'reasons_label')) }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="landing_reasons_title">Reasons heading</label>
                <input id="landing_reasons_title" class="form-control" name="landing_reasons_title"
                       placeholder="e.g. 3 Main Reasons to Join"
                       value="{{ old('landing_reasons_title', data_get($aboutReasons, 'reasons_title')) }}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="landing_reasons_desc">Reasons description</label>
                <textarea id="landing_reasons_desc" rows="3" class="form-control" name="landing_reasons_desc"
                          placeholder="Short paragraph about why someone should attend&hellip;">{{ old('landing_reasons_desc', data_get($aboutReasons, 'reasons_desc')) }}</textarea>
            </div>
        </div>
    </div>
</div>

{{-- 3 reason cards --}}
@for($i = 1; $i <= 3; $i++)
    @php
        $card = $reasons[$i - 1] ?? [];
        $iconDefault = $defaultIcons[$i - 1] ?? 'bi-star';
    @endphp
    <div class="col-md-12">
        <div class="card card-outline card-secondary mb-3">
            <div class="card-header py-2">
                <strong>Reason card {{ $i }}</strong>
            </div>
            <div class="card-body py-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-md-0">
                            <label for="landing_reason_{{ $i }}_icon">Icon class</label>
                            <input id="landing_reason_{{ $i }}_icon" class="form-control" name="landing_reason_{{ $i }}_icon"
                                   placeholder="{{ $iconDefault }}"
                                   value="{{ old("landing_reason_{$i}_icon", data_get($card, 'icon', $iconDefault)) }}">
                            <small class="text-muted">Bootstrap Icons, e.g. <code>bi-globe</code></small>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group mb-md-0">
                            <label for="landing_reason_{{ $i }}_title">Title</label>
                            <input id="landing_reason_{{ $i }}_title" class="form-control" name="landing_reason_{{ $i }}_title"
                                   value="{{ old("landing_reason_{$i}_title", data_get($card, 'title')) }}">
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <div class="form-group mb-0">
                            <label for="landing_reason_{{ $i }}_description">Description</label>
                            <textarea id="landing_reason_{{ $i }}_description" rows="2" class="form-control"
                                      name="landing_reason_{{ $i }}_description">{{ old("landing_reason_{$i}_description", data_get($card, 'description')) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endfor
