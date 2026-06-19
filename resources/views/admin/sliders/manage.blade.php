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
                                <form action="{{ route('admin.sliders.store') }}" method="post" id="form"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="row_id" value="{{ isset($row) ? $row->id : '' }}">

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input id="name" class="form-control" name="name"
                                                        value="{{ isset($row) ? $row->name : old('name') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="order">Order</label>
                                                    <input id="order" type="number" class="form-control" name="order"
                                                        value="{{ isset($row) ? $row->order : old('order') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="url">URL</label>
                                                    <input id="url" class="form-control" name="url"
                                                        value="{{ isset($row) ? $row->url : old('url') }}">
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea id="description" class="form-control" name="description">{{ isset($row) ? $row->description : old('description') }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Slider buttons</label>
                                                    <div class="d-flex gap-3 align-items-center">
                                                        <label class="d-flex align-items-center gap-1">
                                                            <input type="radio" name="use_book_now" value="0"
                                                                {{ !isset($row) || !$row->use_book_now ? 'checked' : '' }}
                                                                class="slider-btn-mode">
                                                            Custom buttons (Button 1 &amp; Button 2)
                                                        </label>
                                                        <label class="d-flex align-items-center gap-1">
                                                            <input type="radio" name="use_book_now" value="1"
                                                                {{ isset($row) && $row->use_book_now ? 'checked' : '' }}
                                                                class="slider-btn-mode">
                                                            Book Now dropdown (country links)
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 slider-custom-buttons">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="btn_text">Button 1 Title</label>
                                                            <input id="btn_text" class="form-control" name="btn_text"
                                                                value="{{ isset($row) ? $row->btn_text : old('btn_text') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="btn_url">Button 1 Url</label>
                                                            <input id="btn_url" class="form-control" name="btn_url"
                                                                value="{{ isset($row) ? $row->btn_url : old('btn_url') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="btn2_text">Button 2 Title</label>
                                                            <input id="btn2_text" class="form-control" name="btn2_text"
                                                                value="{{ isset($row) ? $row->btn2_text : old('btn2_text') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="btn2_url">Button 2 Url</label>
                                                            <input id="btn2_url" class="form-control" name="btn2_url"
                                                                value="{{ isset($row) ? $row->btn2_url : old('btn2_url') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 slider-book-now-url" style="display: none;">
                                                <div class="form-group">
                                                    <label for="book_now_url">Book Now URL (country links)</label>
                                                    <div id="slider-book-now-container">
                                                        @php
                                                            $bookNowUrls = isset($row) ? $row->getBookNowUrl() : [];
                                                        @endphp
                                                        @forelse($bookNowUrls as $index => $entry)
                                                            <div class="row mb-2 slider-book-now-row">
                                                                <div class="col-md-4">
                                                                    <select class="form-control country-code"
                                                                        name="book_now_url[{{ $index }}][country]">
                                                                        @foreach (config('countries') as $code => $country)
                                                                            <option value="{{ $code }}"
                                                                                {{ ($entry->country ?? '') === $code ? 'selected' : '' }}>
                                                                                {{ $country }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="url" class="form-control url"
                                                                        name="book_now_url[{{ $index }}][url]"
                                                                        value="{{ $entry->url ?? '' }}"
                                                                        placeholder="Enter URL">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button type="button"
                                                                        class="btn btn-success add-slider-book-now-row {{ $loop->last ? '' : 'd-none' }}">+</button>
                                                                    <button type="button"
                                                                        class="btn btn-danger remove-slider-book-now-row {{ $loop->first ? 'd-none' : '' }}">−</button>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="row mb-2 slider-book-now-row">
                                                                <div class="col-md-4">
                                                                    <select class="form-control country-code"
                                                                        name="book_now_url[0][country]">
                                                                        @foreach (config('countries') as $code => $country)
                                                                            <option value="{{ $code }}">
                                                                                {{ $country }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="url" class="form-control url"
                                                                        name="book_now_url[0][url]"
                                                                        placeholder="Enter URL">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button type="button"
                                                                        class="btn btn-success add-slider-book-now-row">+</button>
                                                                    <button type="button"
                                                                        class="btn btn-danger remove-slider-book-now-row d-none">−</button>
                                                                </div>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="image">
                                                        Image
                                                        @if (isset($row) && $row->image)
                                                            <a href="{{ $row->image }}" target="_blank">
                                                                show
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endif

                                                    </label>
                                                    <x-file-upload class="form-control" data-folder="sliders"
                                                        name="image-file" />
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
        $(document).ready(function() {
            function toggleSliderButtonSections() {
                const useBookNow = $('input[name="use_book_now"]:checked').val() === '1';
                $('.slider-custom-buttons').toggle(!useBookNow);
                $('.slider-book-now-url').toggle(useBookNow);
            }
            toggleSliderButtonSections();
            $('input.slider-btn-mode').on('change', toggleSliderButtonSections);

            let rowIndex = {{ isset($row) ? count($row->getBookNowUrl()) : 1 }};
            if (rowIndex === 0) rowIndex = 1;

            $(document).on('click', '.add-slider-book-now-row', function() {
                const $originalRow = $(this).closest('.slider-book-now-row');
                const $newRow = $originalRow.clone();
                $newRow.find('select, input').each(function() {
                    const name = $(this).attr('name');
                    if (name) {
                        const updatedName = name.replace(/\[\d+\]/, `[${rowIndex}]`);
                        $(this).attr('name', updatedName);
                    }
                    if ($(this).is('input')) $(this).val('');
                });
                $newRow.find('.add-slider-book-now-row').addClass('d-none');
                $newRow.find('.remove-slider-book-now-row').removeClass('d-none');
                $('#slider-book-now-container').append($newRow);
                rowIndex++;
            });

            $(document).on('click', '.remove-slider-book-now-row', function() {
                $(this).closest('.slider-book-now-row').remove();
            });
        });
    </script>
@endpush
