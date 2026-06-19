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
                            <div class="form-group"><label>Name</label><input class="form-control" name="name" value="{{ $row->name ?? '' }}" required></div>
                            <div class="form-group"><label>Description</label><textarea class="form-control" name="description" rows="2">{{ $row->description ?? '' }}</textarea></div>
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
                            <div class="form-group"><label>Question</label><input class="form-control" name="question" value="{{ $row->question ?? '' }}" required></div>
                            <div class="form-group"><label>Answer</label><textarea class="form-control" name="answer" rows="3">{{ $row->answer ?? '' }}</textarea></div>
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
                        @else
                            <div class="form-group"><label>Image</label><x-file-upload class="form-control" data-folder="nen-landing" name="image-file" /></div>
                            <div class="form-group"><label>Caption</label><input class="form-control" name="caption" value="{{ $row->caption ?? '' }}"></div>
                        @endif
                        <div class="row">
                            <div class="col-md-4"><div class="form-group"><label>Sort Order</label><input type="number" class="form-control" name="sort_order" value="{{ $row->sort_order ?? 0 }}" min="0"></div></div>
                            <div class="col-md-4"><div class="form-check mt-4"><input type="checkbox" name="is_active" value="1" class="form-check-input" {{ !isset($row) || $row->is_active ? 'checked' : '' }}><label class="form-check-label">Active</label></div></div>
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
