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
                                <form action="{{ route('admin.tpi-hero-section.update') }}" method="post" id="form"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">Hero Title</label>
                                                    <input id="title" class="form-control" name="title"
                                                           value="{{ $row->title ?? old('title') }}"
                                                           placeholder="e.g. TOEFL IBT Practice Scholarship">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="subtitle">Subtitle</label>
                                                    <input id="subtitle" class="form-control" name="subtitle"
                                                           value="{{ $row->subtitle ?? old('subtitle') }}"
                                                           placeholder="e.g. Practice. Train. Succeed.">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="apply_btn_text">Apply Button Text</label>
                                                    <input id="apply_btn_text" class="form-control" name="apply_btn_text"
                                                           value="{{ $row->apply_btn_text ?? old('apply_btn_text') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Active</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                                               {{ ($row->is_active ?? true) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Show hero on TPI page</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nearest_center_text">Nearest Center Button Text</label>
                                                    <input id="nearest_center_text" class="form-control" name="nearest_center_text"
                                                           value="{{ $row->nearest_center_text ?? old('nearest_center_text') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nearest_center_url">Nearest Center Button URL</label>
                                                    <input id="nearest_center_url" class="form-control" name="nearest_center_url"
                                                           value="{{ $row->nearest_center_url ?? old('nearest_center_url') }}"
                                                           placeholder="e.g. #authorized-centers">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="image">Hero Image</label>
                                                    @if($row->image ?? null)
                                                        <a href="{{ asset($row->image) }}" target="_blank">Show <i class="fa fa-eye"></i></a>
                                                    @endif
                                                    <input type="hidden" name="image" value="{{ $row->image ?? '' }}">
                                                    <x-file-upload class="form-control" data-folder="site/images" name="image-file"/>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Apply Now – Country Links</label>
                                                    <div id="tpi-hero-countries-container">
                                                        @php $heroCountries = $row->getCountriesList(); @endphp
                                                        @forelse($heroCountries as $index => $entry)
                                                            @php $entry = (array) $entry; @endphp
                                                            <div class="row mb-2 tpi-hero-country-row">
                                                                <div class="col-md-2">
                                                                    <input type="text" class="form-control" name="countries[{{ $index }}][code]"
                                                                           value="{{ $entry['code'] ?? '' }}" placeholder="Code">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input type="text" class="form-control" name="countries[{{ $index }}][name]"
                                                                           value="{{ $entry['name'] ?? '' }}" placeholder="Name">
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <input type="url" class="form-control" name="countries[{{ $index }}][url]"
                                                                           value="{{ $entry['url'] ?? '' }}" placeholder="URL">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input type="text" class="form-control" name="countries[{{ $index }}][flag]"
                                                                           value="{{ $entry['flag'] ?? 'flag-icon-' . ($entry['code'] ?? '') }}" placeholder="flag-icon-xx">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <button type="button" class="btn btn-success add-hero-country {{ $loop->last ? '' : 'd-none' }}">+</button>
                                                                    <button type="button" class="btn btn-danger remove-hero-country {{ $loop->first ? 'd-none' : '' }}">−</button>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="row mb-2 tpi-hero-country-row">
                                                                <div class="col-md-2"><input type="text" class="form-control" name="countries[0][code]" placeholder="Code"></div>
                                                                <div class="col-md-2"><input type="text" class="form-control" name="countries[0][name]" placeholder="Name"></div>
                                                                <div class="col-md-5"><input type="url" class="form-control" name="countries[0][url]" placeholder="URL"></div>
                                                                <div class="col-md-2"><input type="text" class="form-control" name="countries[0][flag]" placeholder="flag-icon-xx"></div>
                                                                <div class="col-md-1">
                                                                    <button type="button" class="btn btn-success add-hero-country">+</button>
                                                                    <button type="button" class="btn btn-danger remove-hero-country d-none">−</button>
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
            let rowIndex = {{ count($row->getCountriesList() ?: []) }};
            if (rowIndex === 0) rowIndex = 1;
            $(document).on('click', '.add-hero-country', function () {
                const $row = $(this).closest('.tpi-hero-country-row');
                const $newRow = $row.clone();
                $newRow.find('input').val('');
                $newRow.find('input').each(function () {
                    const name = $(this).attr('name');
                    if (name) $(this).attr('name', name.replace(/\[\d+\]/, '[' + rowIndex + ']'));
                });
                $newRow.find('.add-hero-country').addClass('d-none');
                $newRow.find('.remove-hero-country').removeClass('d-none');
                $('#tpi-hero-countries-container').append($newRow);
                rowIndex++;
            });
            $(document).on('click', '.remove-hero-country', function () {
                $(this).closest('.tpi-hero-country-row').remove();
            });
        });
    </script>
@endpush
