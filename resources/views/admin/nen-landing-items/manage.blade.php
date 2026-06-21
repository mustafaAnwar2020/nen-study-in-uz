@extends('admin.layouts.admin_dashboard', ['title' => $model])

@section('content')
<div class="content-wrapper">
    @include('admin.layouts.breadcrumb', ['model' => $model])
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header"><h3 class="card-title">{{ $model }}</h3></div>
                <div class="card-body">
                    <form action="{{ route('admin.nen-landing-items.store', $resource) }}" method="post" id="form">
                        @csrf
                        <input type="hidden" name="row_id" value="{{ $row->id ?? '' }}">

                        @if($resource === 'hero-slides')
                            <div class="form-group"><label>Title</label><input class="form-control" name="title" value="{{ $row->title ?? '' }}" required></div>
                            <div class="form-group"><label>Subtitle</label><input class="form-control" name="subtitle" value="{{ $row->subtitle ?? '' }}"></div>
                            <div class="form-group"><label>Background Image</label><x-file-upload class="form-control" data-folder="nen-landing" name="image-file" /></div>
                            <div class="form-group"><label>Button Text</label><input class="form-control" name="btn_text" value="{{ $row->btn_text ?? '' }}"></div>
                            <div class="form-group"><label>Button URL</label><input class="form-control" name="btn_url" value="{{ $row->btn_url ?? '' }}"></div>

                        @elseif($resource === 'partners')
                            <x-localized-field name="name" label="Name" :value="$row->name ?? ''" :value-ar="$row->name_ar ?? ''" required />
                            <x-localized-field name="description" label="Description" type="textarea" :rows="2" :value="$row->description ?? ''" :value-ar="$row->description_ar ?? ''" />
                            <div class="form-group"><label>Image</label><x-file-upload class="form-control" data-folder="nen-landing" name="image-file" /></div>
                            <div class="form-group"><label>URL</label><input class="form-control" name="url" value="{{ $row->url ?? '' }}"></div>

                        @elseif($resource === 'events')
                            <div class="form-group"><label>Type</label>
                                <select class="form-control" name="type">
                                    <option value="highlight" {{ ($row->type ?? '') === 'highlight' ? 'selected' : '' }}>Highlight</option>
                                    <option value="archive" {{ ($row->type ?? '') === 'archive' ? 'selected' : '' }}>Archive</option>
                                </select>
                            </div>
                            <div class="form-group"><label>Title</label><input class="form-control" name="title" value="{{ $row->title ?? '' }}" required></div>
                            <div class="form-group"><label>Description</label><textarea class="form-control" name="description" rows="2">{{ $row->description ?? '' }}</textarea></div>
                            <div class="form-group"><label>Image</label><x-file-upload class="form-control" data-folder="nen-landing" name="image-file" /></div>
                            <div class="form-group"><label>Event Date</label><input type="date" class="form-control" name="event_date" value="{{ isset($row->event_date) ? $row->event_date->format('Y-m-d') : '' }}"></div>
                            <div class="form-group"><label>URL</label><input class="form-control" name="url" value="{{ $row->url ?? '' }}"></div>

                        @elseif($resource === 'faqs')
                            <x-localized-field name="question" label="Question" :value="$row->question ?? ''" :value-ar="$row->question_ar ?? ''" required />
                            <x-localized-field name="answer" label="Answer" type="textarea" :rows="3" :value="$row->answer ?? ''" :value-ar="$row->answer_ar ?? ''" />

                        @elseif($resource === 'media')
                            <div class="form-group"><label>Image</label><x-file-upload class="form-control" data-folder="nen-landing" name="image-file" /></div>
                            <div class="form-group"><label>Caption</label><input class="form-control" name="caption" value="{{ $row->caption ?? '' }}"></div>
                            <div class="form-group">
                                <label>Gallery Position</label>
                                <select class="form-control" name="layout_slot">
                                    <option value="">Auto (by sort order)</option>
                                    @foreach(\App\Models\NenLandingMediaItem::layoutSlots() as $value => $label)
                                        <option value="{{ $value }}" {{ ($row->layout_slot ?? '') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                        @elseif($resource === 'feature-cards')
                            <div class="row">
                                <div class="col-md-3"><div class="form-group"><label>Stat Value <small class="text-muted">(e.g. 100+)</small></label><input class="form-control" name="stat_value" value="{{ $row->stat_value ?? '' }}"></div></div>
                                <div class="col-md-9"><x-localized-field name="stat_label" label="Stat Label" :value="$row->stat_label ?? ''" :value-ar="$row->stat_label_ar ?? ''" /></div>
                            </div>
                            <x-localized-field name="title" label="Title" :value="$row->title ?? ''" :value-ar="$row->title_ar ?? ''" required />
                            <x-localized-field name="description" label="Description" type="textarea" :rows="2" :value="$row->description ?? ''" :value-ar="$row->description_ar ?? ''" />
                            <div class="form-group"><label>Icon Image</label><x-file-upload class="form-control" data-folder="nen-landing" name="image-file" /></div>

                        @elseif($resource === 'how-it-works')
                            <div class="row">
                                <div class="col-md-2"><div class="form-group"><label>Step #</label><input type="number" class="form-control" name="step_number" value="{{ $row->step_number ?? 0 }}" min="0" max="99"></div></div>
                                <div class="col-md-10"><x-localized-field name="title" label="Title" :value="$row->title ?? ''" :value-ar="$row->title_ar ?? ''" required /></div>
                            </div>
                            <x-localized-field name="description" label="Description" type="textarea" :rows="2" :value="$row->description ?? ''" :value-ar="$row->description_ar ?? ''" />
                            <div class="form-group"><label>Step Icon/Image</label><x-file-upload class="form-control" data-folder="nen-landing" name="image-file" /></div>

                        @elseif($resource === 'translation-agencies')
                            <x-localized-field name="name" label="Agency Name" :value="$row->name ?? ''" :value-ar="$row->name_ar ?? ''" required />
                            <x-localized-field name="service_description" label="Service Description" :value="$row->service_description ?? ''" :value-ar="$row->service_description_ar ?? ''" />
                            <div class="form-group"><label>Logo / Image</label><x-file-upload class="form-control" data-folder="nen-landing" name="image-file" /></div>
                            <div class="row">
                                <div class="col-md-6"><x-localized-field name="location" label="City / Location" :value="$row->location ?? ''" :value-ar="$row->location_ar ?? ''" /></div>
                                <div class="col-md-6"><div class="form-group"><label>Phone</label><input class="form-control" name="phone" value="{{ $row->phone ?? '' }}"></div></div>
                            </div>
                            <div class="form-group"><label>Website URL</label><input class="form-control" name="website" value="{{ $row->website ?? '' }}"></div>

                        @elseif($resource === 'trusted-agencies')
                            <x-localized-field name="name" label="Agency Name" :value="$row->name ?? ''" :value-ar="$row->name_ar ?? ''" required />
                            <x-localized-field name="service_description" label="Service Description" :value="$row->service_description ?? ''" :value-ar="$row->service_description_ar ?? ''" />
                            <div class="form-group"><label>Logo / Image</label><x-file-upload class="form-control" data-folder="nen-landing" name="image-file" /></div>
                            <div class="row">
                                <div class="col-md-6"><x-localized-field name="location" label="City / Location" :value="$row->location ?? ''" :value-ar="$row->location_ar ?? ''" /></div>
                                <div class="col-md-6"><div class="form-group"><label>Phone</label><input class="form-control" name="phone" value="{{ $row->phone ?? '' }}"></div></div>
                            </div>
                            <div class="form-group"><label>WhatsApp URL</label><input class="form-control" name="whatsapp_url" value="{{ $row->whatsapp_url ?? '' }}"></div>

                        @elseif($resource === 'documents')
                            <x-localized-field name="title" label="Document Title" :value="$row->title ?? ''" :value-ar="$row->title_ar ?? ''" required />
                            <x-localized-field name="description" label="Description / Note" type="textarea" :rows="2" :value="$row->description ?? ''" :value-ar="$row->description_ar ?? ''" />
                            <div class="form-group"><label>Icon Image</label><x-file-upload class="form-control" data-folder="nen-landing" name="image-file" /></div>

                        @elseif($resource === 'university-logos')
                            <div class="form-group"><label>University / Partner Name <span class="text-danger">*</span></label><input class="form-control" name="name" value="{{ $row->name ?? '' }}" required></div>
                            <div class="form-group"><label>Logo Image</label><x-file-upload class="form-control" data-folder="nen-landing" name="image-file" /></div>
                            <div class="form-group"><label>Website URL</label><input class="form-control" name="url" value="{{ $row->url ?? '' }}"></div>

                        @else
                            <div class="form-group"><label>Image</label><x-file-upload class="form-control" data-folder="nen-landing" name="image-file" /></div>
                            <div class="form-group"><label>Caption</label><input class="form-control" name="caption" value="{{ $row->caption ?? '' }}"></div>
                        @endif

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sort Order</label>
                                    <input type="number" class="form-control" name="sort_order" value="{{ $row->sort_order ?? 0 }}" min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mt-4">
                                    <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                        {{ !isset($row) || $row->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label">Active</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="submit" form="form" class="btn btn-dark">Save</button>
                    <a href="{{ route('admin.nen-landing-items.index', $resource) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
