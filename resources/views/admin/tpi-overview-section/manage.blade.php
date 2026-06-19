@extends('admin.layouts.admin_dashboard', ['title' => $model])

@section('content')
    <div class="content-wrapper">
        @include('admin.layouts.breadcrumb', ['model' => $model])
        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $model }}</h3>
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <form action="{{ route('admin.tpi-overview-section.update') }}" method="post" id="form"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="section_title">Section Title</label>
                                                    <input id="section_title" class="form-control" name="section_title"
                                                           value="{{ $row->section_title ?? old('section_title') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="lead">Lead Paragraph</label>
                                                    <input id="lead" class="form-control" name="lead"
                                                           value="{{ $row->lead ?? old('lead') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="intro_paragraph">Intro Paragraph</label>
                                                    <textarea id="intro_paragraph" class="form-control" name="intro_paragraph" rows="3">{{ $row->intro_paragraph ?? old('intro_paragraph') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="student_image">Student Image</label>
                                                    @if($row->student_image ?? null)
                                                        <a href="{{ asset($row->student_image) }}" target="_blank">Show <i class="fa fa-eye"></i></a>
                                                    @endif
                                                    <input type="hidden" name="student_image" value="{{ $row->student_image ?? '' }}">
                                                    <x-file-upload class="form-control" data-folder="site/images" name="student_image-file"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Active</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                                               {{ ($row->is_active ?? true) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Show overview on TPI page</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Benefits (one per line)</label>
                                                    <div id="tpi-benefits-container">
                                                        @php $benefits = $row->getBenefitsList(); @endphp
                                                        @forelse($benefits as $index => $text)
                                                            <div class="row mb-2 tpi-benefit-row">
                                                                <div class="col-md-11">
                                                                    <input type="text" class="form-control" name="benefits[{{ $index }}]"
                                                                           value="{{ $text }}" placeholder="e.g. 100% Free Practice">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <button type="button" class="btn btn-success add-benefit {{ $loop->last ? '' : 'd-none' }}">+</button>
                                                                    <button type="button" class="btn btn-danger remove-benefit {{ $loop->first ? 'd-none' : '' }}">−</button>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="row mb-2 tpi-benefit-row">
                                                                <div class="col-md-11"><input type="text" class="form-control" name="benefits[0]" placeholder="Benefit text"></div>
                                                                <div class="col-md-1">
                                                                    <button type="button" class="btn btn-success add-benefit">+</button>
                                                                    <button type="button" class="btn btn-danger remove-benefit d-none">−</button>
                                                                </div>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Feature Cards (icon, icon_class, title)</label>
                                                    <div id="tpi-features-container">
                                                        @php $features = $row->getFeaturesList(); @endphp
                                                        @forelse($features as $index => $f)
                                                            @php $f = (array) $f; @endphp
                                                            <div class="row mb-2 tpi-feature-row">
                                                                <div class="col-md-3">
                                                                    <input type="text" class="form-control" name="features[{{ $index }}][icon]"
                                                                           value="{{ $f['icon'] ?? '' }}" placeholder="e.g. bi-book-half">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input type="text" class="form-control" name="features[{{ $index }}][icon_class]"
                                                                           value="{{ $f['icon_class'] ?? '' }}" placeholder="e.g. icon-primary">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control" name="features[{{ $index }}][title]"
                                                                           value="{{ $f['title'] ?? '' }}" placeholder="Title">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <button type="button" class="btn btn-success add-feature {{ $loop->last ? '' : 'd-none' }}">+</button>
                                                                    <button type="button" class="btn btn-danger remove-feature {{ $loop->first ? 'd-none' : '' }}">−</button>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="row mb-2 tpi-feature-row">
                                                                <div class="col-md-3"><input type="text" class="form-control" name="features[0][icon]" placeholder="icon"></div>
                                                                <div class="col-md-2"><input type="text" class="form-control" name="features[0][icon_class]" placeholder="icon_class"></div>
                                                                <div class="col-md-6"><input type="text" class="form-control" name="features[0][title]" placeholder="Title"></div>
                                                                <div class="col-md-1">
                                                                    <button type="button" class="btn btn-success add-feature">+</button>
                                                                    <button type="button" class="btn btn-danger remove-feature d-none">−</button>
                                                                </div>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer clearfix">
                                <button type="submit" form="form" class="btn btn-dark">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let benefitIndex = {{ count($row->getBenefitsList() ?: []) }};
            if (benefitIndex === 0) benefitIndex = 1;
            $(document).on('click', '.add-benefit', function () {
                const $row = $(this).closest('.tpi-benefit-row');
                const $newRow = $row.clone();
                $newRow.find('input').val('');
                $newRow.find('input').attr('name', 'benefits[' + benefitIndex + ']');
                $newRow.find('.add-benefit').addClass('d-none');
                $newRow.find('.remove-benefit').removeClass('d-none');
                $('#tpi-benefits-container').append($newRow);
                benefitIndex++;
            });
            $(document).on('click', '.remove-benefit', function () {
                $(this).closest('.tpi-benefit-row').remove();
            });

            let featureIndex = {{ count($row->getFeaturesList() ?: []) }};
            if (featureIndex === 0) featureIndex = 1;
            $(document).on('click', '.add-feature', function () {
                const $row = $(this).closest('.tpi-feature-row');
                const $newRow = $row.clone();
                $newRow.find('input').val('');
                $newRow.find('input').each(function () {
                    const name = $(this).attr('name');
                    if (name) $(this).attr('name', name.replace(/\[\d+\]/, '[' + featureIndex + ']'));
                });
                $newRow.find('.add-feature').addClass('d-none');
                $newRow.find('.remove-feature').removeClass('d-none');
                $('#tpi-features-container').append($newRow);
                featureIndex++;
            });
            $(document).on('click', '.remove-feature', function () {
                $(this).closest('.tpi-feature-row').remove();
            });
        });
    </script>
@endpush
