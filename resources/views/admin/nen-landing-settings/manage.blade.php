@extends('admin.layouts.admin_dashboard', ['title' => $model, 'hasEditor' => true])

@section('content')
<div class="content-wrapper">
    @include('admin.layouts.breadcrumb', ['model' => $model])
    <section class="content">
        <div class="container-fluid">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            <div class="card">
                <div class="card-header"><h3 class="card-title">{{ $model }}</h3></div>
                <div class="card-body">
                    <form action="{{ route('admin.nen-landing-settings.update') }}" method="post" id="form">
                        @csrf
                        <h5>Hero</h5><hr>
                        <div class="row">
                            <div class="col-md-6"><div class="form-group"><label>Product Title</label><input class="form-control" name="hero_product_title" value="{{ $row->hero_product_title }}"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Subtitle</label><input class="form-control" name="hero_subtitle" value="{{ $row->hero_subtitle }}"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Hero Image</label><x-file-upload class="form-control" data-folder="nen-landing" name="hero_image-file" /></div></div>
                            <div class="col-md-3"><div class="form-group"><label>Button Text</label><input class="form-control" name="hero_btn_text" value="{{ $row->hero_btn_text }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label>Button URL</label><input class="form-control" name="hero_btn_url" value="{{ $row->hero_btn_url }}"></div></div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="featured_event_id">Featured event (hero countdown)</label>
                                    <select id="featured_event_id" class="form-control" name="featured_event_id">
                                        <option value="">— None —</option>
                                        @foreach ($featuredEventOptions as $eventOption)
                                            <option value="{{ $eventOption->id }}"{{ (int) old('featured_event_id', $row->featured_event_id) === (int) $eventOption->id ? ' selected' : '' }}>
                                                {{ $eventOption->name }}@if($eventOption->date) ({{ $eventOption->date }})@endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">
                                        Countdown dates are set on the event landing page (Event starts / Registration ends).
                                    </small>
                                </div>
                            </div>
                        </div>
                        <h5 class="mt-3">About NEN</h5><hr>
                        <div class="row">
                            <div class="col-md-4"><div class="form-group"><label>Label</label><input class="form-control" name="about_label" value="{{ $row->about_label }}"></div></div>
                            <div class="col-md-8"><div class="form-group"><label>Title</label><input class="form-control" name="about_title" value="{{ $row->about_title }}"></div></div>
                            <div class="col-md-12"><div class="form-group"><label>Description</label><textarea class="form-control" name="about_description" rows="4">{{ $row->about_description }}</textarea></div></div>
                            <div class="col-md-3"><div class="form-group"><label>Metric 1 Value</label><input class="form-control" name="about_metric1_value" value="{{ $row->about_metric1_value }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label>Metric 1 Label</label><input class="form-control" name="about_metric1_label" value="{{ $row->about_metric1_label }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label>Metric 2 Value</label><input class="form-control" name="about_metric2_value" value="{{ $row->about_metric2_value }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label>Metric 2 Label</label><input class="form-control" name="about_metric2_label" value="{{ $row->about_metric2_label }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label>Badge Value</label><input class="form-control" name="about_stat_value" value="{{ $row->about_stat_value }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label>Badge Label</label><input class="form-control" name="about_stat_label" value="{{ $row->about_stat_label }}"></div></div>
                            <div class="col-md-4"><div class="form-group"><label>Collage Image (Top)</label><x-file-upload class="form-control" data-folder="nen-landing" name="about_image_main-file" /></div></div>
                            <div class="col-md-4"><div class="form-group"><label>Collage Image (Bottom)</label><x-file-upload class="form-control" data-folder="nen-landing" name="about_image_secondary-file" /></div></div>
                            <div class="col-md-4"><div class="form-group"><label>Collage Image (Side)</label><x-file-upload class="form-control" data-folder="nen-landing" name="about_image_side-file" /></div></div>
                        </div>
                        <h5 class="mt-3">Section Headings & Footer</h5><hr>
                        <div class="row">
                            @foreach(['highlights_title','highlights_subtitle','archive_title','archive_subtitle','archive_btn_text','archive_btn_url','partners_title','faq_title','media_title','contact_title','footer_phone','footer_copyright','footer_collaboration_text','footer_collaboration_url'] as $field)
                                <div class="col-md-6"><div class="form-group"><label>{{ str_replace('_',' ', ucfirst($field)) }}</label><input class="form-control" name="{{ $field }}" value="{{ $row->$field }}"></div></div>
                            @endforeach
                            <div class="col-md-12"><div class="form-group"><label>Contact Description</label><textarea class="form-control" name="contact_description" rows="2">{{ $row->contact_description }}</textarea></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Contact Email</label><input class="form-control" name="contact_email" value="{{ $row->contact_email }}"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Contact Headquarters</label><input class="form-control" name="contact_headquarters" value="{{ $row->contact_headquarters }}"></div></div>
                        </div>
                    </form>
                </div>
                <div class="card-footer"><button type="submit" form="form" class="btn btn-dark">Save</button></div>
            </div>
        </div>
    </section>
</div>
@endsection
