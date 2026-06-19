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
                                <form action="{{ route('admin.tpi-cta-section.update') }}" method="post" id="form"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">Section Title</label>
                                                    <input id="title" class="form-control" name="title"
                                                           value="{{ $row->title ?? old('title') }}"
                                                           placeholder="e.g. Ready to Practice TOEFL">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lead">Lead Text</label>
                                                    <input id="lead" class="form-control" name="lead"
                                                           value="{{ $row->lead ?? old('lead') }}"
                                                           placeholder="e.g. Start Now - Only $10 Refundable Deposit">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pay_btn_text">Pay Button Text</label>
                                                    <input id="pay_btn_text" class="form-control" name="pay_btn_text"
                                                           value="{{ $row->pay_btn_text ?? old('pay_btn_text') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Show Section</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                                               {{ ($row->is_active ?? true) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Active</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="image">Image</label>
                                                    @if($row->image ?? null)
                                                        <a href="{{ asset($row->image) }}" target="_blank">Show <i class="fa fa-eye"></i></a>
                                                    @endif
                                                    <input type="hidden" name="image" id="tpi-cta-image" value="{{ $row->image ?? '' }}">
                                                    <x-file-upload class="form-control" data-folder="site/images" name="image-file"/>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Pay Now – Payment Options</label>
                                                    <div id="tpi-payment-options-container">
                                                        @php $options = $row->getPaymentOptionsList(); @endphp
                                                        @forelse($options as $index => $entry)
                                                            @php $entry = (array) $entry; @endphp
                                                            <div class="row mb-2 tpi-payment-row">
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control" name="payment_options[{{ $index }}][label]"
                                                                           value="{{ $entry['label'] ?? '' }}" placeholder="Label (e.g. Pay in EGP (500 EGP))">
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <input type="url" class="form-control" name="payment_options[{{ $index }}][url]"
                                                                           value="{{ $entry['url'] ?? '' }}" placeholder="Payment URL">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input type="text" class="form-control" name="payment_options[{{ $index }}][icon]"
                                                                           value="{{ $entry['icon'] ?? '' }}" placeholder="e.g. flag-icon-eg">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <button type="button" class="btn btn-success add-tpi-payment {{ $loop->last ? '' : 'd-none' }}">+</button>
                                                                    <button type="button" class="btn btn-danger remove-tpi-payment {{ $loop->first ? 'd-none' : '' }}">−</button>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="row mb-2 tpi-payment-row">
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control" name="payment_options[0][label]" placeholder="Label">
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <input type="url" class="form-control" name="payment_options[0][url]" placeholder="URL">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input type="text" class="form-control" name="payment_options[0][icon]" placeholder="flag-icon-xx">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <button type="button" class="btn btn-success add-tpi-payment">+</button>
                                                                    <button type="button" class="btn btn-danger remove-tpi-payment d-none">−</button>
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
            let rowIndex = {{ count($row->getPaymentOptionsList() ?: []) }};
            if (rowIndex === 0) rowIndex = 1;

            $(document).on('click', '.add-tpi-payment', function () {
                const $row = $(this).closest('.tpi-payment-row');
                const $newRow = $row.clone();
                $newRow.find('input').val('');
                $newRow.find('input').each(function () {
                    const name = $(this).attr('name');
                    if (name) $(this).attr('name', name.replace(/\[\d+\]/, '[' + rowIndex + ']'));
                });
                $newRow.find('.add-tpi-payment').addClass('d-none');
                $newRow.find('.remove-tpi-payment').removeClass('d-none');
                $('#tpi-payment-options-container').append($newRow);
                rowIndex++;
            });

            $(document).on('click', '.remove-tpi-payment', function () {
                $(this).closest('.tpi-payment-row').remove();
            });
        });
    </script>
@endpush
