@php
    $detailsMap = $detailsMap ?? [];
@endphp
<div class="col-md-12 mt-3">
    <hr>
    <span class="badge badge-info">Section: event details &amp; map</span>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="landing_details_label">Section label</label>
        <input id="landing_details_label" class="form-control" name="landing_details_label"
               placeholder="e.g. EVENT DETAILS"
               value="{{ old('landing_details_label', data_get($detailsMap, 'label')) }}">
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="landing_details_title">Heading</label>
        <input id="landing_details_title" class="form-control" name="landing_details_title"
               placeholder="e.g. Know More About Our Event"
               value="{{ old('landing_details_title', data_get($detailsMap, 'title')) }}">
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="landing_details_description">Description</label>
        <textarea id="landing_details_description" rows="3" class="form-control"
                  name="landing_details_description">{{ old('landing_details_description', data_get($detailsMap, 'description')) }}</textarea>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="landing_details_date">Date</label>
        <input id="landing_details_date" class="form-control" name="landing_details_date"
               placeholder="Leave empty to use hero / event date"
               value="{{ old('landing_details_date', data_get($detailsMap, 'date')) }}">
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="landing_details_time">Time</label>
        <input id="landing_details_time" class="form-control" name="landing_details_time"
               placeholder="Leave empty to use hero / event time"
               value="{{ old('landing_details_time', data_get($detailsMap, 'time')) }}">
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="landing_details_venue">Venue</label>
        <input id="landing_details_venue" class="form-control" name="landing_details_venue"
               value="{{ old('landing_details_venue', data_get($detailsMap, 'venue')) }}">
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="landing_details_address">Address</label>
        <input id="landing_details_address" class="form-control" name="landing_details_address"
               value="{{ old('landing_details_address', data_get($detailsMap, 'address')) }}">
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="landing_details_map_embed_url">Google Maps embed URL</label>
        <textarea id="landing_details_map_embed_url" rows="3" class="form-control"
                  name="landing_details_map_embed_url"
                  placeholder="Paste the embed URL (src=...) or full iframe HTML from Google Maps.">{{ old('landing_details_map_embed_url', data_get($detailsMap, 'map_embed_url')) }}</textarea>
        <small class="text-muted">If empty, the event&rsquo;s location field is used when it is a Google Maps link.</small>
    </div>
</div>
