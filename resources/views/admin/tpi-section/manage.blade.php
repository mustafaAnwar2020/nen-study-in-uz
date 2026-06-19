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
                                <form action="{{ route('admin.tpi-section.update') }}" method="post" id="form"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">Section Title</label>
                                                    <input id="title" class="form-control" name="title"
                                                           value="{{ $row->title ?? old('title') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="heading">Heading</label>
                                                    <input id="heading" class="form-control" name="heading"
                                                           value="{{ $row->heading ?? old('heading') }}"
                                                           placeholder="e.g. Practice. Train. Succeed.">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="benefit1">Benefit 1 (short line)</label>
                                                    <input id="benefit1" class="form-control" name="benefit1"
                                                           value="{{ $row->benefit1 ?? old('benefit1') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="benefit2">Benefit 2 (paragraph)</label>
                                                    <textarea id="benefit2" class="form-control" name="benefit2"
                                                              rows="2">{{ $row->benefit2 ?? old('benefit2') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="cta_text">CTA Text (e.g. Book now and take your official exam within 6 months!)</label>
                                                    <input id="cta_text" class="form-control" name="cta_text"
                                                           value="{{ $row->cta_text ?? old('cta_text') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="deposit_amount">Deposit Amount</label>
                                                    <input id="deposit_amount" class="form-control" name="deposit_amount"
                                                           value="{{ $row->deposit_amount ?? old('deposit_amount') }}"
                                                           placeholder="e.g. $10">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="practice_tests_count">Practice Tests Count</label>
                                                    <input id="practice_tests_count" class="form-control"
                                                           name="practice_tests_count"
                                                           value="{{ $row->practice_tests_count ?? old('practice_tests_count') }}"
                                                           placeholder="e.g. 3">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="months_text">Months Text</label>
                                                    <input id="months_text" class="form-control" name="months_text"
                                                           value="{{ $row->months_text ?? old('months_text') }}"
                                                           placeholder="e.g. 6 months">
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
                                                    <label for="learn_more_text">Learn More Button Text</label>
                                                    <input id="learn_more_text" class="form-control" name="learn_more_text"
                                                           value="{{ $row->learn_more_text ?? old('learn_more_text') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="learn_more_url">Learn More Button URL</label>
                                                    <input id="learn_more_url" class="form-control" name="learn_more_url"
                                                           value="{{ $row->learn_more_url ?? old('learn_more_url') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="image">Hero Image</label>
                                                    @if($row->image ?? null)
                                                        <a href="{{ asset($row->image) }}" target="_blank">Show <i class="fa fa-eye"></i></a>
                                                    @endif
                                                    <x-file-upload class="form-control" data-folder="site/images" name="image-file"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Active</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                                               {{ ($row->is_active ?? true) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Show section on homepage</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Apply Now – Country Links</label>
                                                    <div id="tpi-countries-container">
                                                        @php $tpiCountries = $row->getCountriesList(); @endphp
                                                        @forelse($tpiCountries as $index => $entry)
                                                            @php $entry = (array) $entry; @endphp
                                                            <div class="row mb-2 tpi-country-row">
                                                                <div class="col-md-2">
                                                                    <input type="text" class="form-control" name="countries[{{ $index }}][code]"
                                                                           value="{{ $entry['code'] ?? '' }}" placeholder="Code (e.g. eg)">
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
                                                                           value="{{ $entry['flag'] ?? 'flag-icon-' . ($entry['code'] ?? '') }}"
                                                                           placeholder="flag-icon-xx">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <button type="button" class="btn btn-success add-tpi-country {{ $loop->last ? '' : 'd-none' }}">+</button>
                                                                    <button type="button" class="btn btn-danger remove-tpi-country {{ $loop->first ? 'd-none' : '' }}">−</button>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="row mb-2 tpi-country-row">
                                                                <div class="col-md-2">
                                                                    <input type="text" class="form-control" name="countries[0][code]" placeholder="Code">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input type="text" class="form-control" name="countries[0][name]" placeholder="Name">
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <input type="url" class="form-control" name="countries[0][url]" placeholder="URL">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input type="text" class="form-control" name="countries[0][flag]" placeholder="flag-icon-xx">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <button type="button" class="btn btn-success add-tpi-country">+</button>
                                                                    <button type="button" class="btn btn-danger remove-tpi-country d-none">−</button>
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

            $(document).on('click', '.add-tpi-country', function () {
                const $row = $(this).closest('.tpi-country-row');
                const $newRow = $row.clone();
                $newRow.find('input').val('');
                $newRow.find('input').each(function () {
                    const name = $(this).attr('name');
                    if (name) $(this).attr('name', name.replace(/\[\d+\]/, '[' + rowIndex + ']'));
                });
                $newRow.find('.add-tpi-country').addClass('d-none');
                $newRow.find('.remove-tpi-country').removeClass('d-none');
                $('#tpi-countries-container').append($newRow);
                rowIndex++;
            });

            $(document).on('click', '.remove-tpi-country', function () {
                $(this).closest('.tpi-country-row').remove();
            });
        });
    </script>
@endpush
