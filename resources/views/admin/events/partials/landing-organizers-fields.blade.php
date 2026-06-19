@php
    $organizersContent = $organizers ?? [];
    $mapLocations = $mapLocations ?? collect();
    $storedMapLocationIds = data_get($organizersContent, 'map_location_ids');
    $mapUseAll = old('landing_organizers_map_use_all', $storedMapLocationIds === null ? '1' : '0');
    $mapIdsSource = old('landing_organizers_map_location_ids', $storedMapLocationIds);
    $selectedMapLocationIds = array_map('intval', is_array($mapIdsSource) ? $mapIdsSource : []);
    $mainMapLocations = $mapLocations->where('location_type', \App\Models\Location::TYPE_MAIN);
    $authorizedMapLocations = $mapLocations->where('location_type', \App\Models\Location::TYPE_AUTHORIZED);
    $networkStats = data_get($organizersContent, 'network_stats', []);
    $defaultStatTitles = ['Students', 'Training Centers', 'Certified Trainers', 'Testing Centers', 'Invigilators'];
    $defaultStatValues = ['2,1M+', '2K+', '4K+', '550+', '200+'];
    $defaultStatIcons = ['bi-mortarboard', '', '', '', 'bi-person-bounding-box'];
    $defaultStatImages = ['', '/site/images/training_centers.png', '/site/images/sales.png', '/site/images/testing_centers.png', ''];
    $organizerStatIconOptions = config('landing_bootstrap_icons.organizers_stat', []);
@endphp
<div class="col-md-12 mt-3">
    <hr>
    <span class="badge badge-info">Section: NEN organizers (map &amp; network)</span>
    <p class="text-muted small mb-0 mt-1">
        Same block as the homepage NEN section: logo, description, Learn more link, Become a partner link, office map, and network stats.
    </p>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="landing_organizers_label">Section heading</label>
        <input id="landing_organizers_label" class="form-control" name="landing_organizers_label"
               placeholder="e.g. Organizers"
               value="{{ old('landing_organizers_label', data_get($organizersContent, 'section_label')) }}">
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="landing_organizers_logo">
            Logo (optional)
            @if(data_get($organizersContent, 'logo'))
                <a href="{{ asset(data_get($organizersContent, 'logo')) }}" target="_blank" rel="noopener">show <i class="fa fa-eye"></i></a>
            @endif
        </label>
        <x-file-upload class="form-control" data-folder="events" name="landing_organizers_logo-file"/>
        @if($existingLogo = old('landing_organizers_logo', data_get($organizersContent, 'logo')))
            <input type="hidden" name="landing_organizers_logo" value="{{ $existingLogo }}">
        @endif
        <small class="text-muted">Leave empty to use the default NEN logo.</small>
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
        <label for="landing_organizers_description">Description</label>
        <textarea id="landing_organizers_description" rows="6" class="form-control" name="landing_organizers_description"
                  placeholder="NEN | National Education Network is a strategic network…">{{ old('landing_organizers_description', data_get($organizersContent, 'description')) }}</textarea>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="landing_organizers_btn_text">Learn more button text</label>
        <input id="landing_organizers_btn_text" class="form-control" name="landing_organizers_btn_text"
               placeholder="Learn more"
               value="{{ old('landing_organizers_btn_text', data_get($organizersContent, 'btn_text', 'Learn more')) }}">
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="landing_organizers_btn_url">Learn more URL</label>
        <input id="landing_organizers_btn_url" class="form-control" name="landing_organizers_btn_url"
               placeholder="https://www.nen-global.org/EN/index.html"
               value="{{ old('landing_organizers_btn_url', data_get($organizersContent, 'btn_url', 'https://www.nen-global.org/EN/index.html')) }}">
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="landing_organizers_partner_btn_text">Become a partner button text</label>
        <input id="landing_organizers_partner_btn_text" class="form-control" name="landing_organizers_partner_btn_text"
               placeholder="Become a partner"
               value="{{ old('landing_organizers_partner_btn_text', data_get($organizersContent, 'partner_btn_text', 'Become a partner')) }}">
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="landing_organizers_partner_btn_url">Become a partner URL</label>
        <input id="landing_organizers_partner_btn_url" class="form-control" name="landing_organizers_partner_btn_url"
               placeholder="{{ url('/TPS') }}"
               value="{{ old('landing_organizers_partner_btn_url', data_get($organizersContent, 'partner_btn_url', url('/TPS'))) }}">
    </div>
</div>

<div class="col-md-12 mt-2">
    <h5 class="text-muted">Map offices</h5>
    <p class="text-muted small mb-2">
        Offices are managed under <a href="{{ route('admin.locations.index') }}" target="_blank" rel="noopener">Locations</a>.
        <strong>Main Offices</strong> = red markers; <strong>Authorized Offices</strong> = blue markers (same as homepage).
        Country flags use selected main offices only.
    </p>
</div>

<div class="col-md-12">
    <div class="form-group mb-2">
        <input type="hidden" name="landing_organizers_map_use_all" value="0">
        <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary mb-0">
            <input type="checkbox" name="landing_organizers_map_use_all" id="landing_organizers_map_use_all" value="1"
                   {{ (string) $mapUseAll === '1' ? 'checked' : '' }}>
            <span class="mr-2"></span>
            Show all active locations (same as homepage)
        </label>
    </div>
</div>

<div class="col-md-12 organizers-map-picker {{ (string) $mapUseAll === '1' ? 'd-none' : '' }}" id="organizers_map_picker">
    <div class="mb-2">
        <button type="button" class="btn btn-sm btn-outline-secondary organizers-map-select-main">All main offices</button>
        <button type="button" class="btn btn-sm btn-outline-secondary organizers-map-select-authorized">All authorized offices</button>
        <button type="button" class="btn btn-sm btn-outline-secondary organizers-map-select-all">Select all</button>
        <button type="button" class="btn btn-sm btn-outline-danger organizers-map-select-none">Clear all</button>
    </div>

    @if($mainMapLocations->isNotEmpty())
        <div class="card card-outline card-primary mb-3">
            <div class="card-header py-2"><strong>Main Offices</strong> <span class="badge badge-danger">red marker</span></div>
            <div class="card-body py-3">
                <div class="row">
                    @foreach($mainMapLocations as $mapLocation)
                        <div class="col-md-6 col-lg-4 mb-2">
                            <label class="d-flex align-items-center mb-0">
                                <input type="checkbox" class="mr-2 organizers-map-location-cb organizers-map-location-main"
                                       name="landing_organizers_map_location_ids[]"
                                       value="{{ $mapLocation->id }}"
                                       {{ in_array($mapLocation->id, $selectedMapLocationIds, true) ? 'checked' : '' }}>
                                <span class="flag-icon flag-icon-{{ $mapLocation->country_code }} mr-2"></span>
                                <span>
                                    {{ config('countries.'.$mapLocation->country_code, strtoupper($mapLocation->country_code)) }}
                                    @if($mapLocation->name)
                                        <small class="text-muted d-block">{{ $mapLocation->name }}</small>
                                    @endif
                                </span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if($authorizedMapLocations->isNotEmpty())
        <div class="card card-outline card-info mb-3">
            <div class="card-header py-2"><strong>Authorized Offices</strong> <span class="badge badge-primary">blue marker</span></div>
            <div class="card-body py-3">
                <div class="row">
                    @foreach($authorizedMapLocations as $mapLocation)
                        <div class="col-md-6 col-lg-4 mb-2">
                            <label class="d-flex align-items-center mb-0">
                                <input type="checkbox" class="mr-2 organizers-map-location-cb organizers-map-location-authorized"
                                       name="landing_organizers_map_location_ids[]"
                                       value="{{ $mapLocation->id }}"
                                       {{ in_array($mapLocation->id, $selectedMapLocationIds, true) ? 'checked' : '' }}>
                                <span class="flag-icon flag-icon-{{ $mapLocation->country_code }} mr-2"></span>
                                <span>
                                    {{ config('countries.'.$mapLocation->country_code, strtoupper($mapLocation->country_code)) }}
                                    @if($mapLocation->name)
                                        <small class="text-muted d-block">{{ $mapLocation->name }}</small>
                                    @endif
                                </span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if($mapLocations->isEmpty())
        <p class="text-warning small">No active locations found. Add locations in admin first.</p>
    @endif
</div>

<div class="col-md-12">
    <h5 class="text-muted mt-2">Network statistics (under map)</h5>
</div>

@for($i = 1; $i <= \App\Services\EventLandingPageService::ORGANIZERS_NETWORK_STAT_SLOTS; $i++)
    @php
        $stat = $networkStats[$i - 1] ?? [];
        $titleDefault = $defaultStatTitles[$i - 1] ?? '';
        $valueDefault = $defaultStatValues[$i - 1] ?? '';
        $iconDefault = $defaultStatIcons[$i - 1] ?? '';
        $imageDefault = $defaultStatImages[$i - 1] ?? '';
        $selectedIcon = old("landing_organizers_stat_{$i}_icon", data_get($stat, 'icon', $iconDefault));
        $existingImage = old("landing_organizers_stat_{$i}_image", data_get($stat, 'image', $imageDefault));
    @endphp
    <div class="col-md-6 col-lg-4">
        <div class="card card-outline card-secondary mb-3 organizers-stat-card">
            <div class="card-header py-2"><strong>Stat {{ $i }}</strong></div>
            <div class="card-body py-3">
                <div class="form-group">
                    <label for="landing_organizers_stat_{{ $i }}_title">Title</label>
                    <input id="landing_organizers_stat_{{ $i }}_title" class="form-control" name="landing_organizers_stat_{{ $i }}_title"
                           placeholder="{{ $titleDefault }}"
                           value="{{ old("landing_organizers_stat_{$i}_title", data_get($stat, 'title', $titleDefault)) }}">
                </div>
                <div class="form-group">
                    <label for="landing_organizers_stat_{{ $i }}_value">Value</label>
                    <input id="landing_organizers_stat_{{ $i }}_value" class="form-control" name="landing_organizers_stat_{{ $i }}_value"
                           placeholder="{{ $valueDefault }}"
                           value="{{ old("landing_organizers_stat_{$i}_value", data_get($stat, 'value', $valueDefault)) }}">
                </div>
                @include('admin.partials.bootstrap-icon-select', [
                    'id' => "landing_organizers_stat_{$i}_icon",
                    'name' => "landing_organizers_stat_{$i}_icon",
                    'selected' => $selectedIcon,
                    'options' => $organizerStatIconOptions,
                    'selectClass' => 'organizers-stat-icon-select',
                    'label' => 'Icon',
                    'emptyPreviewClass' => 'bi-dash-lg',
                ])
                <small class="text-muted d-block mt-1 organizers-stat-icon-hint">Pick an icon or upload an image — not both.</small>
                <div class="form-group mb-0 organizers-stat-image-field">
                    <label>
                        Custom image
                        <span class="organizers-stat-image-preview">
                            @if($existingImage && !$selectedIcon)
                                <a href="{{ asset($existingImage) }}" target="_blank" rel="noopener">show <i class="fa fa-eye"></i></a>
                            @endif
                        </span>
                    </label>
                    <div class="organizers-stat-image-upload">
                        <x-file-upload class="form-control" data-folder="events" name="landing_organizers_stat_{{ $i }}_image-file"/>
                    </div>
                    <div class="organizers-stat-image-persist">
                        @if($existingImage && !$selectedIcon)
                            <input type="hidden" name="landing_organizers_stat_{{ $i }}_image" value="{{ $existingImage }}">
                        @endif
                    </div>
                    <small class="text-muted d-block mt-1 organizers-stat-image-hint">Used only when icon is &ldquo;None&rdquo;. Max 5 MB.</small>
                </div>
            </div>
        </div>
    </div>
@endfor

@push('scripts')
    <script>
        $(function () {
            var $mapUseAll = $('#landing_organizers_map_use_all');
            var $mapPicker = $('#organizers_map_picker');

            function toggleMapPicker() {
                var useAll = $mapUseAll.is(':checked');
                $mapPicker.toggleClass('d-none', useAll);
                $mapPicker.find('.organizers-map-location-cb').prop('disabled', useAll);
            }

            $mapUseAll.on('change', toggleMapPicker);
            toggleMapPicker();

            function setMapCheckboxes(selector, checked) {
                $mapPicker.find(selector).prop('checked', checked);
            }

            $('.organizers-map-select-main').on('click', function () { setMapCheckboxes('.organizers-map-location-main', true); });
            $('.organizers-map-select-authorized').on('click', function () { setMapCheckboxes('.organizers-map-location-authorized', true); });
            $('.organizers-map-select-all').on('click', function () { setMapCheckboxes('.organizers-map-location-cb', true); });
            $('.organizers-map-select-none').on('click', function () { setMapCheckboxes('.organizers-map-location-cb', false); });

            function syncOrganizersStatCard($card) {
                var hasIcon = !!$card.find('.organizers-stat-icon-select').val();
                var $imageField = $card.find('.organizers-stat-image-field');
                var $upload = $imageField.find('.organizers-stat-image-upload');
                var $persist = $imageField.find('.organizers-stat-image-persist');
                var $preview = $imageField.find('.organizers-stat-image-preview');

                if (hasIcon) {
                    $persist.find('input[type="hidden"][name$="_image"]').remove();
                    $preview.empty();
                    $upload.find('input[type="file"]').prop('disabled', true);
                    $imageField.addClass('organizers-stat-image-field--disabled');
                    $card.find('.organizers-stat-icon-hint').html('<span class="text-info">Custom image will be removed when you save with this icon.</span>');
                    $card.find('.organizers-stat-image-hint').text('Disabled while an icon is selected.');
                } else {
                    $upload.find('input[type="file"]').prop('disabled', false);
                    $imageField.removeClass('organizers-stat-image-field--disabled');
                    $card.find('.organizers-stat-icon-hint').text('Pick an icon or upload an image — not both.');
                    $card.find('.organizers-stat-image-hint').text('Used only when icon is “None”. Max 5 MB.');
                }
            }

            $('.organizers-stat-card').each(function () { syncOrganizersStatCard($(this)); });
            $(document).on('change', '.organizers-stat-icon-select', function () {
                if (window.bootstrapIconSelect) {
                    window.bootstrapIconSelect.updatePreview(this);
                }
                syncOrganizersStatCard($(this).closest('.organizers-stat-card'));
            });
            if (window.bootstrapIconSelect) {
                window.bootstrapIconSelect.initAll(document);
            }
            $(document).on('change', '.organizers-stat-image-field input[type="hidden"][name$="_image"]', function () {
                if (!$(this).val()) return;
                var $card = $(this).closest('.organizers-stat-card');
                $card.find('.organizers-stat-icon-select').val('');
                syncOrganizersStatCard($card);
            });
        });
    </script>
    <style>
        .organizers-stat-image-field--disabled { opacity: 0.55; pointer-events: none; }
    </style>
@endpush
