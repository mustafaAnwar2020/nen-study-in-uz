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
                            <x-localized-field :source="$row ?? null" name="hero_product_title" label="Product Title" :value="$row->hero_product_title" :value-ar="$row->hero_product_title_ar ?? ''" />
                            <x-localized-field :source="$row ?? null" name="hero_subtitle" label="Subtitle" :value="$row->hero_subtitle" :value-ar="$row->hero_subtitle_ar ?? ''" />
                            <div class="col-md-6"><div class="form-group"><label>Hero Image (fallback)</label><x-file-upload class="form-control" data-folder="nen-landing" name="hero_image-file" /></div></div>
                            <x-localized-field :source="$row ?? null" name="hero_btn_text" label="Button Text" :value="$row->hero_btn_text" :value-ar="$row->hero_btn_text_ar ?? ''" />
                            <div class="col-md-3"><div class="form-group"><label>Button URL</label><input class="form-control" name="hero_btn_url" value="{{ $row->hero_btn_url }}"></div></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Official Partner Logo (bottom-right of hero)</label>
                                    <input type="hidden" name="hero_official_logo" value="{{ $row->hero_official_logo }}">
                                    <x-file-upload class="form-control" data-folder="nen-landing" name="hero_official_logo-file" />
                                    @if ($row->hero_official_logo)
                                        <small class="form-text text-muted">Current: <a href="{{ asset($row->hero_official_logo) }}" target="_blank">{{ $row->hero_official_logo }}</a></small>
                                    @endif
                                </div>
                            </div>
                            <x-localized-field :source="$row ?? null" name="hero_official_label" label="Official Partner Label" :value="$row->hero_official_label" :value-ar="$row->hero_official_label_ar ?? ''" placeholder="Official Partner" />
                            <div class="col-md-3 d-flex align-items-end"><p class="text-muted small mb-3"><a href="{{ route('admin.nen-landing-items.index', 'partners') }}">→ Manage partner logos &amp; names</a></p></div>
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
                            <x-localized-field :source="$row ?? null" name="about_label" label="Label" :value="$row->about_label" :value-ar="$row->about_label_ar ?? ''" />
                            <x-localized-field :source="$row ?? null" name="about_title" label="Title" :value="$row->about_title" :value-ar="$row->about_title_ar ?? ''" />
                            <div class="col-md-12">
                                <x-localized-field :source="$row ?? null" name="about_description" label="Description" type="textarea" :rows="4" :value="$row->about_description" :value-ar="$row->about_description_ar ?? ''" />
                            </div>
                            <div class="col-md-3"><div class="form-group"><label>Metric 1 Value</label><input class="form-control" name="about_metric1_value" value="{{ $row->about_metric1_value }}"></div></div>
                            <x-localized-field :source="$row ?? null" name="about_metric1_label" label="Metric 1 Label" :value="$row->about_metric1_label" :value-ar="$row->about_metric1_label_ar ?? ''" />
                            <div class="col-md-3"><div class="form-group"><label>Metric 2 Value</label><input class="form-control" name="about_metric2_value" value="{{ $row->about_metric2_value }}"></div></div>
                            <x-localized-field :source="$row ?? null" name="about_metric2_label" label="Metric 2 Label" :value="$row->about_metric2_label" :value-ar="$row->about_metric2_label_ar ?? ''" />
                            <div class="col-md-3"><div class="form-group"><label>Badge Value</label><input class="form-control" name="about_stat_value" value="{{ $row->about_stat_value }}"></div></div>
                            <x-localized-field :source="$row ?? null" name="about_stat_label" label="Badge Label" :value="$row->about_stat_label" :value-ar="$row->about_stat_label_ar ?? ''" />
                            <div class="col-md-4"><div class="form-group"><label>Collage Image (Top)</label><x-file-upload class="form-control" data-folder="nen-landing" name="about_image_main-file" /></div></div>
                            <div class="col-md-4"><div class="form-group"><label>Collage Image (Bottom)</label><x-file-upload class="form-control" data-folder="nen-landing" name="about_image_secondary-file" /></div></div>
                            <div class="col-md-4"><div class="form-group"><label>Collage Image (Side)</label><x-file-upload class="form-control" data-folder="nen-landing" name="about_image_side-file" /></div></div>
                        </div>

                        {{-- ==================== FEATURES (WHY UZBEKISTAN) ==================== --}}
                        <h5 class="mt-3">Why Uzbekistan (Feature Cards)</h5><hr>
                        <div class="row">
                            <x-localized-field :source="$row ?? null" name="features_title" label="Section Title" :value="$row->features_title" :value-ar="$row->features_title_ar ?? ''" />
                            <x-localized-field :source="$row ?? null" name="features_subtitle" label="Section Subtitle" :value="$row->features_subtitle" :value-ar="$row->features_subtitle_ar ?? ''" />
                        </div>
                        <p class="text-muted small"><a href="{{ route('admin.nen-landing-items.index', 'feature-cards') }}">→ Manage Feature Cards</a></p>

                        {{-- ==================== HOW IT WORKS ==================== --}}
                        <h5 class="mt-3">How It Works</h5><hr>
                        <x-localized-field :source="$row ?? null" name="how_it_works_title" label="Section Title" :value="$row->how_it_works_title" :value-ar="$row->how_it_works_title_ar ?? ''" />
                        <x-localized-field :source="$row ?? null" name="how_it_works_subtitle" label="Section Subtitle" :value="$row->how_it_works_subtitle" :value-ar="$row->how_it_works_subtitle_ar ?? ''" />
                        <div class="row">
                            <div class="col-md-4"><x-localized-field :source="$row ?? null" name="how_it_works_btn_text" label="CTA Button Text" :value="$row->how_it_works_btn_text" :value-ar="$row->how_it_works_btn_text_ar ?? ''" /></div>
                            <div class="col-md-8"><div class="form-group"><label>CTA Button URL</label><input class="form-control" name="how_it_works_btn_url" value="{{ $row->how_it_works_btn_url }}"></div></div>
                        </div>
                        <p class="text-muted small"><a href="{{ route('admin.nen-landing-items.index', 'how-it-works') }}">→ Manage Steps</a></p>

                        {{-- ==================== MILESTONES ==================== --}}
                        <h5 class="mt-3">NEN Milestones</h5><hr>
                        <x-localized-field :source="$row ?? null" name="milestones_title" label="Section Title" :value="$row->milestones_title" :value-ar="$row->milestones_title_ar ?? ''" />
                        <x-localized-field :source="$row ?? null" name="milestones_subtitle" label="Subtitle / Tagline" type="textarea" :rows="2" :value="$row->milestones_subtitle" :value-ar="$row->milestones_subtitle_ar ?? ''" />
                        <x-localized-field :source="$row ?? null" name="milestones_description" label="Description (bottom paragraph)" type="textarea" :rows="3" :value="$row->milestones_description" :value-ar="$row->milestones_description_ar ?? ''" />
                        <div class="row">
                            <div class="col-md-4"><x-localized-field :source="$row ?? null" name="milestones_cta_text" label="CTA Button Text" :value="$row->milestones_cta_text" :value-ar="$row->milestones_cta_text_ar ?? ''" /></div>
                            <div class="col-md-8"><div class="form-group"><label>CTA Button URL</label><input class="form-control" name="milestones_cta_url" value="{{ $row->milestones_cta_url }}"></div></div>
                        </div>

                        {{-- ==================== EVENTS / ARCHIVE ==================== --}}
                        <h5 class="mt-3">Events & Archive</h5><hr>
                        @foreach(['highlights_title','highlights_subtitle','archive_title','archive_subtitle','archive_btn_text'] as $field)
                            <x-localized-field :source="$row ?? null" :name="$field" :label="str_replace('_',' ', ucfirst($field))" :value="$row->$field" :value-ar="$row->{$field . '_ar'} ?? ''" />
                        @endforeach
                        <div class="row">
                            <div class="col-md-6"><div class="form-group"><label>Archive Button URL</label><input class="form-control" name="archive_btn_url" value="{{ $row->archive_btn_url }}"></div></div>
                        </div>

                        {{-- ==================== TRANSLATION AGENCIES ==================== --}}
                        <h5 class="mt-3">Certified Translation Agencies</h5><hr>
                        <x-localized-field :source="$row ?? null" name="agencies_title" label="Section Title" :value="$row->agencies_title" :value-ar="$row->agencies_title_ar ?? ''" />
                        <x-localized-field :source="$row ?? null" name="agencies_subtitle" label="Section Subtitle" :value="$row->agencies_subtitle" :value-ar="$row->agencies_subtitle_ar ?? ''" />
                        <p class="text-muted small"><a href="{{ route('admin.nen-landing-items.index', 'translation-agencies') }}">→ Manage Translation Agencies</a></p>

                        {{-- ==================== DOCUMENTS ==================== --}}
                        <h5 class="mt-3">Required Application Documents</h5><hr>
                        <x-localized-field :source="$row ?? null" name="documents_title" label="Section Title" :value="$row->documents_title" :value-ar="$row->documents_title_ar ?? ''" />
                        <x-localized-field :source="$row ?? null" name="documents_subtitle" label="Section Subtitle" :value="$row->documents_subtitle" :value-ar="$row->documents_subtitle_ar ?? ''" />
                        <p class="text-muted small"><a href="{{ route('admin.nen-landing-items.index', 'documents') }}">→ Manage Documents</a></p>

                        {{-- ==================== TRUSTED AGENCIES ==================== --}}
                        <h5 class="mt-3">Trusted Study Abroad Agencies</h5><hr>
                        <x-localized-field :source="$row ?? null" name="trusted_agencies_title" label="Section Title" :value="$row->trusted_agencies_title" :value-ar="$row->trusted_agencies_title_ar ?? ''" />
                        <x-localized-field :source="$row ?? null" name="trusted_agencies_subtitle" label="Section Subtitle" :value="$row->trusted_agencies_subtitle" :value-ar="$row->trusted_agencies_subtitle_ar ?? ''" />
                        <p class="text-muted small"><a href="{{ route('admin.nen-landing-items.index', 'trusted-agencies') }}">→ Manage Trusted Agencies</a></p>

                        {{-- ==================== PARTNERS ==================== --}}
                        <h5 class="mt-3">Organizers & Partners</h5><hr>
                        <x-localized-field :source="$row ?? null" name="partners_title" label="Section Title" :value="$row->partners_title" :value-ar="$row->partners_title_ar ?? ''" />
                        <p class="text-muted small"><a href="{{ route('admin.nen-landing-items.index', 'partners') }}">→ Manage Partners</a></p>

                        {{-- ==================== UNIVERSITY LOGOS ==================== --}}
                        <h5 class="mt-3">University Logos (Success Partners)</h5><hr>
                        <x-localized-field :source="$row ?? null" name="university_logos_title" label="Section Title" :value="$row->university_logos_title" :value-ar="$row->university_logos_title_ar ?? ''" />
                        <p class="text-muted small"><a href="{{ route('admin.nen-landing-items.index', 'university-logos') }}">→ Manage University Logos</a></p>

                        {{-- ==================== MEDIA / FAQ / CONTACT ==================== --}}
                        <h5 class="mt-3">Media, FAQ &amp; Contact</h5><hr>
                        @foreach(['faq_title','media_title','contact_title'] as $field)
                            <x-localized-field :source="$row ?? null" :name="$field" :label="str_replace('_',' ', ucfirst($field))" :value="$row->$field" :value-ar="$row->{$field . '_ar'} ?? ''" />
                        @endforeach
                        <x-localized-field :source="$row ?? null" name="contact_description" label="Contact Description" type="textarea" :rows="2" :value="$row->contact_description" :value-ar="$row->contact_description_ar ?? ''" />
                        <div class="row">
                            <div class="col-md-6"><div class="form-group"><label>Contact Email</label><input class="form-control" name="contact_email" value="{{ $row->contact_email }}"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Contact Headquarters</label><input class="form-control" name="contact_headquarters" value="{{ $row->contact_headquarters }}"></div></div>
                        </div>

                        {{-- ==================== FOOTER / HEADER / NAV ==================== --}}
                        <h5 class="mt-3">Footer, Header &amp; Navigation</h5><hr>
                        <div class="row">
                            <div class="col-md-12">
                                <x-localized-field :source="$row ?? null" name="footer_tagline" label="Footer Tagline" :value="$row->footer_tagline ?? ''" :value-ar="$row->footer_tagline_ar ?? ''" />
                            </div>
                            @foreach(['footer_phone','footer_collaboration_url','header_register_url','nav_about_url','nav_events_url','nav_partners_url','nav_contact_url'] as $field)
                                <div class="col-md-6"><div class="form-group"><label>{{ str_replace('_',' ', ucfirst($field)) }}</label><input class="form-control" name="{{ $field }}" value="{{ $row->$field }}"></div></div>
                            @endforeach
                            <x-localized-field :source="$row ?? null" name="footer_copyright" label="Footer Copyright" :value="$row->footer_copyright" :value-ar="$row->footer_copyright_ar ?? ''" />
                            <x-localized-field :source="$row ?? null" name="footer_collaboration_text" label="Footer Collaboration Text" :value="$row->footer_collaboration_text" :value-ar="$row->footer_collaboration_text_ar ?? ''" />
                            <x-localized-field :source="$row ?? null" name="header_register_text" label="Header Register Text" :value="$row->header_register_text" :value-ar="$row->header_register_text_ar ?? ''" />
                        </div>

                    </form>
                </div>
                <div class="card-footer"><button type="submit" form="form" class="btn btn-dark">Save All Settings</button></div>
            </div>
        </div>
    </section>
</div>
@endsection
