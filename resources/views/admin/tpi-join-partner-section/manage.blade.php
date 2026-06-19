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
                                <form action="{{ route('admin.tpi-join-partner-section.update') }}" method="post" id="form">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="section_title">Section Title</label>
                                                    <input id="section_title" class="form-control" name="section_title"
                                                           value="{{ $row->section_title ?? old('section_title') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Active</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                                               {{ ($row->is_active ?? true) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Show section on TPI page</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Partner Cards (icon, icon_class, title, description, button_text, button_url)</label>
                                                    <div id="tpi-join-partner-container">
                                                        @php $items = $row->getItemsList(); @endphp
                                                        @forelse($items as $index => $item)
                                                            @php $item = (array) $item; @endphp
                                                            <div class="border rounded p-3 mb-3 tpi-join-partner-row">
                                                                <div class="row mb-2">
                                                                    <div class="col-md-2">
                                                                        <input type="text" class="form-control" name="items[{{ $index }}][icon]"
                                                                               value="{{ $item['icon'] ?? '' }}" placeholder="e.g. bi-building">
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <input type="text" class="form-control" name="items[{{ $index }}][icon_class]"
                                                                               value="{{ $item['icon_class'] ?? '' }}" placeholder="e.g. icon-primary">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="text" class="form-control" name="items[{{ $index }}][title]"
                                                                               value="{{ $item['title'] ?? '' }}" placeholder="Title">
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button type="button" class="btn btn-success add-join-partner {{ $loop->last ? '' : 'd-none' }}">+</button>
                                                                        <button type="button" class="btn btn-danger remove-join-partner {{ $loop->first ? 'd-none' : '' }}">−</button>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-md-11">
                                                                        <textarea class="form-control" name="items[{{ $index }}][description]" rows="2" placeholder="Description">{{ $item['description'] ?? '' }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <input type="text" class="form-control" name="items[{{ $index }}][button_text]"
                                                                               value="{{ $item['button_text'] ?? '' }}" placeholder="Button text">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input type="url" class="form-control" name="items[{{ $index }}][button_url]"
                                                                               value="{{ $item['button_url'] ?? '' }}" placeholder="Button URL">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="border rounded p-3 mb-3 tpi-join-partner-row">
                                                                <div class="row mb-2">
                                                                    <div class="col-md-2"><input type="text" class="form-control" name="items[0][icon]" placeholder="icon"></div>
                                                                    <div class="col-md-2"><input type="text" class="form-control" name="items[0][icon_class]" placeholder="icon_class"></div>
                                                                    <div class="col-md-4"><input type="text" class="form-control" name="items[0][title]" placeholder="Title"></div>
                                                                    <div class="col-md-2">
                                                                        <button type="button" class="btn btn-success add-join-partner">+</button>
                                                                        <button type="button" class="btn btn-danger remove-join-partner d-none">−</button>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-md-11"><textarea class="form-control" name="items[0][description]" rows="2" placeholder="Description"></textarea></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-5"><input type="text" class="form-control" name="items[0][button_text]" placeholder="Button text"></div>
                                                                    <div class="col-md-6"><input type="url" class="form-control" name="items[0][button_url]" placeholder="Button URL"></div>
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
            let rowIndex = {{ count($row->getItemsList() ?: []) }};
            if (rowIndex === 0) rowIndex = 1;
            $(document).on('click', '.add-join-partner', function () {
                const $row = $(this).closest('.tpi-join-partner-row');
                const $newRow = $row.clone();
                $newRow.find('input, textarea').val('');
                $newRow.find('input, textarea').each(function () {
                    const name = $(this).attr('name');
                    if (name) $(this).attr('name', name.replace(/\[\d+\]/, '[' + rowIndex + ']'));
                });
                $newRow.find('.add-join-partner').addClass('d-none');
                $newRow.find('.remove-join-partner').removeClass('d-none');
                $('#tpi-join-partner-container').append($newRow);
                rowIndex++;
            });
            $(document).on('click', '.remove-join-partner', function () {
                $(this).closest('.tpi-join-partner-row').remove();
            });
        });
    </script>
@endpush
