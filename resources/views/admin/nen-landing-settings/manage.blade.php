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

                        {{-- ==================== SECTION VISIBILITY ==================== --}}
                        <h5>Section Visibility</h5><hr>
                        <p class="text-muted small">Toggle which sections are displayed on the homepage.</p>
                        <div class="row">
                            @foreach([
                                'show_hero'             => 'Hero Slider',
                                'show_about'            => 'About NEN',
                                'show_events'           => 'Events / Highlights',
                                'show_archive'          => 'Archive',
                                'show_features'         => 'Why Uzbekistan (Feature Cards)',
                                'show_how_it_works'     => 'How It Works',
                                'show_milestones'       => 'NEN Milestones',
                                'show_agencies'         => 'Certified Translation Agencies',
                                'show_documents'        => 'Required Documents',
                                'show_trusted_agencies' => 'Trusted Study Abroad Agencies',
                                'show_partners'         => 'Partners',
                                'show_university_logos' => 'University Logos (Success Partners)',
                                'show_media'            => 'Media Gallery',
                                'show_faq'              => 'FAQ',
                                'show_contact'          => 'Contact Form',
                            ] as $field => $label)
                            <div class="col-md-4">
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="{{ $field }}" value="1" class="form-check-input" id="{{ $field }}"
                                        {{ old($field, $row->{$field} ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $field }}">{{ $label }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- ==================== HERO ==================== --}}
                        <h5 class="mt-3">Hero</h5><hr>
                        <div class="row">
                            <div class="col-md-6"><div class="form-group"><label>Product Title</label><input class="form-control" name="hero_product_title" value="{{ $row->hero_product_title }}"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Subtitle</label><input class="form-control" name="hero_subtitle" value="{{ $row->hero_subtitle }}"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Hero Image (fallback)</label><x-file-upload class="form-control" data-folder="nen-landing" name="hero_image-file" /></div></div>
                            <div class="col-md-3"><div class="form-group"><label>Button Text</label><input class="form-control" name="hero_btn_text" value="{{ $row->hero_btn_text }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label>Button URL</label><input class="form-control" name="hero_btn_url" value="{{ $row->hero_btn_url }}"></div></div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="featured_event_id">Featured Event (Hero Countdown)</label>
                                    <select id="featured_event_id" class="form-control" name="featured_event_id">
                                        <option value="">— None —</option>
                                        @foreach ($featuredEventOptions as $eventOption)
                                            <option value="{{ $eventOption->id }}"{{ (int) old('featured_event_id', $row->featured_event_id) === (int) $eventOption->id ? ' selected' : '' }}>
                                                {{ $eventOption->name }}@if($eventOption->date) ({{ $eventOption->date }})@endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Countdown dates are set on the event landing page.</small>
                                </div>
                            </div>
                        </div>

                        {{-- ==================== ABOUT ==================== --}}
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

                        {{-- ==================== FEATURES (WHY UZBEKISTAN) ==================== --}}
                        <h5 class="mt-3">Why Uzbekistan (Feature Cards)</h5><hr>
                        <div class="row">
                            <div class="col-md-6"><div class="form-group"><label>Section Title</label><input class="form-control" name="features_title" value="{{ $row->features_title }}"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Section Subtitle</label><input class="form-control" name="features_subtitle" value="{{ $row->features_subtitle }}"></div></div>
                        </div>
                        <p class="text-muted small"><a href="{{ route('admin.nen-landing-items.index', 'feature-cards') }}">→ Manage Feature Cards</a></p>

                        {{-- ==================== HOW IT WORKS ==================== --}}
                        <h5 class="mt-3">How It Works</h5><hr>
                        <div class="row">
                            <div class="col-md-6"><div class="form-group"><label>Section Title</label><input class="form-control" name="how_it_works_title" value="{{ $row->how_it_works_title }}"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Section Subtitle</label><input class="form-control" name="how_it_works_subtitle" value="{{ $row->how_it_works_subtitle }}"></div></div>
                            <div class="col-md-4"><div class="form-group"><label>CTA Button Text</label><input class="form-control" name="how_it_works_btn_text" value="{{ $row->how_it_works_btn_text }}"></div></div>
                            <div class="col-md-8"><div class="form-group"><label>CTA Button URL</label><input class="form-control" name="how_it_works_btn_url" value="{{ $row->how_it_works_btn_url }}"></div></div>
                        </div>
                        <p class="text-muted small"><a href="{{ route('admin.nen-landing-items.index', 'how-it-works') }}">→ Manage Steps</a></p>

                        {{-- ==================== MILESTONES ==================== --}}
                        <h5 class="mt-3">NEN Milestones</h5><hr>
                        <div class="row">
                            <div class="col-md-12"><div class="form-group"><label>Section Title</label><input class="form-control" name="milestones_title" value="{{ $row->milestones_title }}"></div></div>
                            <div class="col-md-12"><div class="form-group"><label>Subtitle / Tagline</label><textarea class="form-control" name="milestones_subtitle" rows="2">{{ $row->milestones_subtitle }}</textarea></div></div>
                            <div class="col-md-12"><div class="form-group"><label>Description (bottom paragraph)</label><textarea class="form-control" name="milestones_description" rows="3">{{ $row->milestones_description }}</textarea></div></div>
                            <div class="col-md-4"><div class="form-group"><label>CTA Button Text</label><input class="form-control" name="milestones_cta_text" value="{{ $row->milestones_cta_text }}"></div></div>
                            <div class="col-md-8"><div class="form-group"><label>CTA Button URL</label><input class="form-control" name="milestones_cta_url" value="{{ $row->milestones_cta_url }}"></div></div>
                        </div>

                        {{-- ==================== EVENTS / ARCHIVE ==================== --}}
                        <h5 class="mt-3">Events & Archive</h5><hr>
                        <div class="row">
                            @foreach(['highlights_title','highlights_subtitle','archive_title','archive_subtitle','archive_btn_text','archive_btn_url'] as $field)
                                <div class="col-md-6"><div class="form-group"><label>{{ str_replace('_',' ', ucfirst($field)) }}</label><input class="form-control" name="{{ $field }}" value="{{ $row->$field }}"></div></div>
                            @endforeach
                        </div>

                        {{-- ==================== TRANSLATION AGENCIES ==================== --}}
                        <h5 class="mt-3">Certified Translation Agencies</h5><hr>
                        <div class="row">
                            <div class="col-md-6"><div class="form-group"><label>Section Title</label><input class="form-control" name="agencies_title" value="{{ $row->agencies_title }}"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Section Subtitle</label><input class="form-control" name="agencies_subtitle" value="{{ $row->agencies_subtitle }}"></div></div>
                        </div>
                        <p class="text-muted small"><a href="{{ route('admin.nen-landing-items.index', 'translation-agencies') }}">→ Manage Translation Agencies</a></p>

                        {{-- ==================== DOCUMENTS ==================== --}}
                        <h5 class="mt-3">Required Application Documents</h5><hr>
                        <div class="row">
                            <div class="col-md-6"><div class="form-group"><label>Section Title</label><input class="form-control" name="documents_title" value="{{ $row->documents_title }}"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Section Subtitle</label><input class="form-control" name="documents_subtitle" value="{{ $row->documents_subtitle }}"></div></div>
                        </div>
                        <p class="text-muted small"><a href="{{ route('admin.nen-landing-items.index', 'documents') }}">→ Manage Documents</a></p>

                        {{-- ==================== TRUSTED AGENCIES ==================== --}}
                        <h5 class="mt-3">Trusted Study Abroad Agencies</h5><hr>
                        <div class="row">
                            <div class="col-md-6"><div class="form-group"><label>Section Title</label><input class="form-control" name="trusted_agencies_title" value="{{ $row->trusted_agencies_title }}"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Section Subtitle</label><input class="form-control" name="trusted_agencies_subtitle" value="{{ $row->trusted_agencies_subtitle }}"></div></div>
                        </div>
                        <p class="text-muted small"><a href="{{ route('admin.nen-landing-items.index', 'trusted-agencies') }}">→ Manage Trusted Agencies</a></p>

                        {{-- ==================== PARTNERS ==================== --}}
                        <h5 class="mt-3">Organizers & Partners</h5><hr>
                        <div class="row">
                            <div class="col-md-6"><div class="form-group"><label>Section Title</label><input class="form-control" name="partners_title" value="{{ $row->partners_title }}"></div></div>
                        </div>
                        <p class="text-muted small"><a href="{{ route('admin.nen-landing-items.index', 'partners') }}">→ Manage Partners</a></p>

                        {{-- ==================== UNIVERSITY LOGOS ==================== --}}
                        <h5 class="mt-3">University Logos (Success Partners)</h5><hr>
                        <div class="row">
                            <div class="col-md-6"><div class="form-group"><label>Section Title</label><input class="form-control" name="university_logos_title" value="{{ $row->university_logos_title }}"></div></div>
                        </div>
                        <p class="text-muted small"><a href="{{ route('admin.nen-landing-items.index', 'university-logos') }}">→ Manage University Logos</a></p>

                        {{-- ==================== MEDIA / FAQ / CONTACT ==================== --}}
                        <h5 class="mt-3">Media, FAQ &amp; Contact</h5><hr>
                        <div class="row">
                            @foreach(['faq_title','media_title','contact_title'] as $field)
                                <div class="col-md-4"><div class="form-group"><label>{{ str_replace('_',' ', ucfirst($field)) }}</label><input class="form-control" name="{{ $field }}" value="{{ $row->$field }}"></div></div>
                            @endforeach
                            <div class="col-md-12"><div class="form-group"><label>Contact Description</label><textarea class="form-control" name="contact_description" rows="2">{{ $row->contact_description }}</textarea></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Contact Email</label><input class="form-control" name="contact_email" value="{{ $row->contact_email }}"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Contact Headquarters</label><input class="form-control" name="contact_headquarters" value="{{ $row->contact_headquarters }}"></div></div>
                        </div>

                        {{-- ==================== FOOTER / HEADER / NAV ==================== --}}
                        <h5 class="mt-3">Footer, Header &amp; Navigation</h5><hr>
                        <div class="row">
                            @foreach(['footer_phone','footer_copyright','footer_collaboration_text','footer_collaboration_url','header_register_text','header_register_url','nav_about_url','nav_events_url','nav_partners_url','nav_contact_url'] as $field)
                                <div class="col-md-6"><div class="form-group"><label>{{ str_replace('_',' ', ucfirst($field)) }}</label><input class="form-control" name="{{ $field }}" value="{{ $row->$field }}"></div></div>
                            @endforeach
                        </div>

                    </form>
                </div>
                <div class="card-footer"><button type="submit" form="form" class="btn btn-dark">Save All Settings</button></div>
            </div>
        </div>
    </section>
</div>
@endsection
