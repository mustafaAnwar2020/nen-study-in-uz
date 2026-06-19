@php
    $statsContent = $stats ?? [];
    $statItems = data_get($statsContent, 'stats', []);
    $defaultIcons = ['bi-people-fill', 'bi-mic-fill', 'bi-mortarboard-fill', 'bi-calendar-event'];
    $defaultLabels = ['Attendees', 'Speakers', 'Universities', 'Sessions'];
@endphp
<div class="col-md-12 mt-3">
    <hr>
    <span class="badge badge-info">Section: statistics bar</span>
</div>

@for($i = 1; $i <= 4; $i++)
    @php
        $stat = $statItems[$i - 1] ?? [];
        $iconDefault = $defaultIcons[$i - 1] ?? 'bi-star';
        $labelDefault = $defaultLabels[$i - 1] ?? '';
    @endphp
    <div class="col-md-6 col-lg-3">
        <div class="card card-outline card-secondary mb-3">
            <div class="card-header py-2"><strong>Stat {{ $i }}</strong></div>
            <div class="card-body py-3">
                <div class="form-group">
                    <label for="landing_stat_{{ $i }}_icon">Icon</label>
                    <input id="landing_stat_{{ $i }}_icon" class="form-control" name="landing_stat_{{ $i }}_icon"
                           placeholder="{{ $iconDefault }}"
                           value="{{ old("landing_stat_{$i}_icon", data_get($stat, 'icon', $iconDefault)) }}">
                </div>
                <div class="form-group">
                    <label for="landing_stat_{{ $i }}_value">Value</label>
                    <input id="landing_stat_{{ $i }}_value" class="form-control" name="landing_stat_{{ $i }}_value"
                           placeholder="e.g. 200+"
                           value="{{ old("landing_stat_{$i}_value", data_get($stat, 'value')) }}">
                </div>
                <div class="form-group mb-0">
                    <label for="landing_stat_{{ $i }}_label">Label</label>
                    <input id="landing_stat_{{ $i }}_label" class="form-control" name="landing_stat_{{ $i }}_label"
                           placeholder="{{ $labelDefault }}"
                           value="{{ old("landing_stat_{$i}_label", data_get($stat, 'label')) }}">
                </div>
            </div>
        </div>
    </div>
@endfor
