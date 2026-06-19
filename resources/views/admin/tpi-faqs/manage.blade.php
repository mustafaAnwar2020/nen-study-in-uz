@extends('admin.layouts.admin_dashboard', ['title' => $model])

@section('content')
    <div class="content-wrapper">
        @include('admin.layouts.breadcrumb', ['model' => $model])
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $model }}</h3>
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <form action="{{ route('admin.tpi-faqs.store') }}" method="post" id="form">
                                    @csrf
                                    <input type="hidden" name="row_id" value="{{ $row->id ?? '' }}">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="question">Question</label>
                                                    <input id="question" class="form-control" name="question"
                                                           value="{{ $row->question ?? old('question') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="answer">Answer</label>
                                                    <textarea id="answer" class="form-control" name="answer" rows="4" required>{{ $row->answer ?? old('answer') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="sort_order">Sort Order</label>
                                                    <input type="number" id="sort_order" class="form-control" name="sort_order"
                                                           value="{{ $row->sort_order ?? old('sort_order', 0) }}" min="0">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Active</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                                               {{ isset($row) ? ($row->is_active ? 'checked' : '') : 'checked' }}>
                                                        <label class="form-check-label">Show on TPI page</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer clearfix">
                                <button type="submit" form="form" class="btn btn-dark">Save</button>
                                <a href="{{ route('admin.tpi-faqs.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
