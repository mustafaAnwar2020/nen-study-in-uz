@extends('admin.layouts.admin_dashboard', ['title'=>$model])

@section('content')


    <div class="content-wrapper">
        @include('admin.layouts.breadcrumb', ['model'=>$model])
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{$model}}</h3>
                            </div>

                            <div class="card-body p-0 table-responsive">
                                <form action="{{route('admin.offers.store')}}" method="post" id="form"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="row_id" value="{{isset($row) ? $row->id : ''}}">

                                    <div class="modal-body">

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input id="name" class="form-control" name="name"
                                                           value="{{isset($row) ? $row->name : old('name')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="country_code">Country</label>
                                                    <select id="country_code" class="form-control" name="country_code">
                                                        <option {{ (isset($row) && $row->country_code == 'all')  ? 'selected' : ''  }} value="all">
                                                            All
                                                        </option>
                                                        <option {{ (isset($row) && $row->country_code == 'online')  ? 'selected' : ''  }} value="online">
                                                            Online
                                                        </option>
                                                        @foreach(config('countries') as $code=>$country)
                                                            <option
                                                                    {{ (isset($row) && $row->country_code == $code)  ? 'selected' : ''  }}
                                                                    value="{{$code}}">{{$country}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Book Now</label>
                                                    <div class="d-flex flex-wrap align-items-center" style="gap: 1rem;">
                                                        <label class="d-flex align-items-center mb-0">
                                                            <input type="radio" name="use_book_now" value="0"
                                                                   class="offer-slider-btn-mode mr-2"
                                                                    {{ old('use_book_now', isset($row) && $row->use_book_now ? '1' : '0') === '0' ? 'checked' : '' }}>
                                                            Single URL
                                                        </label>
                                                        <label class="d-flex align-items-center mb-0">
                                                            <input type="radio" name="use_book_now" value="1"
                                                                   class="offer-slider-btn-mode mr-2"
                                                                    {{ old('use_book_now', isset($row) && $row->use_book_now ? '1' : '0') === '1' ? 'checked' : '' }}>
                                                            Book Now by country (dropdown)
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 offer-book-now-single">
                                                <div class="form-group">
                                                    <label for="book_now_url">Book Now URL</label>
                                                    <input id="book_now_url" class="form-control" name="book_now_url"
                                                           value="{{isset($row) ? $row->book_now_url : old('book_now_url')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="book_now_text">Book Now button label</label>
                                                    <input id="book_now_text" class="form-control" type="text"
                                                           name="book_now_text"
                                                           value="{{ isset($row) ? $row->book_now_text : old('book_now_text') }}"
                                                           placeholder="e.g. Book now">
                                                    <small class="form-text text-muted">Leave empty to use the default label "Book Now".</small>
                                                </div>
                                            </div>

                                            <div class="col-md-12 offer-book-now-by-country" style="display: none;">
                                                <div class="form-group">
                                                    <label>Book Now URLs by country</label>
                                                    <div id="offer-book-now-container">
                                                        @php
                                                            $bookNowUrls = isset($row) ? $row->getBookNowUrl() : [];
                                                        @endphp
                                                        @forelse($bookNowUrls as $index => $entry)
                                                            <div class="row mb-2 offer-book-now-row">
                                                                <div class="col-md-4">
                                                                    <select class="form-control"
                                                                            name="book_now_country_links[{{ $index }}][country]">
                                                                        @foreach(config('countries') as $code => $country)
                                                                            <option value="{{ $code }}"
                                                                                {{ ($entry->country ?? '') === $code ? 'selected' : '' }}>
                                                                                {{ $country }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="url" class="form-control"
                                                                           name="book_now_country_links[{{ $index }}][url]"
                                                                           value="{{ $entry->url ?? '' }}"
                                                                           placeholder="https://">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button type="button"
                                                                            class="btn btn-success add-offer-book-now-row {{ $loop->last ? '' : 'd-none' }}">+</button>
                                                                    <button type="button"
                                                                            class="btn btn-danger remove-offer-book-now-row {{ $loop->first ? 'd-none' : '' }}">−</button>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="row mb-2 offer-book-now-row">
                                                                <div class="col-md-4">
                                                                    <select class="form-control"
                                                                            name="book_now_country_links[0][country]">
                                                                        @foreach(config('countries') as $code => $country)
                                                                            <option value="{{ $code }}">{{ $country }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="url" class="form-control"
                                                                           name="book_now_country_links[0][url]"
                                                                           placeholder="https://">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button type="button" class="btn btn-success add-offer-book-now-row">+</button>
                                                                    <button type="button"
                                                                            class="btn btn-danger remove-offer-book-now-row d-none">−</button>
                                                                </div>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="more_details_text">More details — button label</label>
                                                    <input id="more_details_text" class="form-control" type="text"
                                                           name="more_details_text"
                                                           value="{{ isset($row) ? $row->more_details_text : old('more_details_text') }}"
                                                           placeholder="e.g. More details">
                                                    <small class="form-text text-muted">Shown only when label and URL are both set.</small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="more_details_url">More details — URL</label>
                                                    <input id="more_details_url" class="form-control" type="url"
                                                           name="more_details_url"
                                                           value="{{ isset($row) ? $row->more_details_url : old('more_details_url') }}"
                                                           placeholder="https://">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="date">Date</label>
                                                    <input id="date" type="date" class="form-control" name="date"
                                                           value="{{isset($row) ? $row->date : old('date')}}">
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="image">
                                                        Image (photo)
                                                        @if(isset($row) && $row->image)
                                                            <a href="{{ asset($row->image) }}" target="_blank" rel="noopener">Open <i class="fa fa-eye"></i></a>
                                                        @endif
                                                    </label>
                                                    <x-file-upload class="form-control" data-folder="offers" name="image-file"/>
                                                    @if(isset($row) && $row->image)
                                                        <div class="mt-2 border rounded p-1 bg-light">
                                                            <img src="{{ asset($row->image) }}" alt="" class="img-fluid" style="max-height: 120px;">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="offer-video-upload">Video file</label>
                                                    <small class="d-block text-muted mb-1">MP4, WebM, MOV — max ~100 MB</small>
                                                    <x-file-upload
                                                        class="form-control"
                                                        data-folder="offers"
                                                        name="video-file"
                                                        accept=".mp4,.m4v,.mov,.webm,.ogg"
                                                        data-upload-kind="offer_video"
                                                        data-max-kb="102400"
                                                        data-allowed-ext="mp4,m4v,mov,webm,ogg"
                                                    />
                                                    @if(isset($row) && $row->video)
                                                        <div class="mt-2 border rounded p-2 bg-light">
                                                            <video controls playsinline preload="metadata" src="{{ asset($row->video) }}" class="w-100" style="max-height: 160px;"></video>
                                                            <label class="d-block small mt-2 mb-0">
                                                                <input type="checkbox" name="remove_video" value="1"> Remove current video
                                                            </label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="offer-pdf-upload">PDF</label>
                                                    <small class="d-block text-muted mb-1">Max ~20 MB</small>
                                                    <x-file-upload
                                                        class="form-control"
                                                        data-folder="offers"
                                                        name="pdf-file"
                                                        accept=".pdf"
                                                        data-upload-kind="offer_pdf"
                                                        data-max-kb="20480"
                                                        data-allowed-ext="pdf"
                                                    />
                                                    @if(isset($row) && $row->pdf)
                                                        <div class="mt-2 border rounded p-2 bg-light">
                                                            <p class="small text-muted mb-2">Preview loads only when you choose an action (avoids auto-download in the browser).</p>
                                                            <button type="button" class="btn btn-sm btn-outline-primary mb-1 offer-admin-pdf-preview-btn" data-pdf-url="{{ asset($row->pdf) }}">Load preview</button>
                                                            <a href="{{ asset($row->pdf) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary d-inline-block mb-2">Open in new tab</a>
                                                            <div class="offer-admin-pdf-preview-frame border rounded bg-white" style="display: none; min-height: 180px;"></div>
                                                            <label class="d-block small mt-2 mb-0">
                                                                <input type="checkbox" name="remove_pdf" value="1"> Remove current PDF
                                                            </label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea id="description" rows="3" class="form-control"
                                                              name="description">{{isset($row) ? $row->description : old('description')}}</textarea>
                                                </div>
                                            </div>


                                        </div>


                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="is_active">
                                                        Is Active?
                                                    </label><br>
                                                    <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary mb-2">
                                                        <input type="checkbox" value="1" name="is_active"
                                                                {{ (!isset($row) ? 'checked' : (!empty($row) && isset($row->is_active) && $row->is_active == 1 ? 'checked' : '')) }}>
                                                        <span class="mr-3"> </span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="is_online">
                                                        Is Online?
                                                    </label><br>
                                                    <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary mb-2">
                                                        <input type="checkbox" value="1" name="is_online"
                                                                {{ (!isset($row) ? 'checked' : (!empty($row) && isset($row->is_online) && $row->is_online == 1 ? 'checked' : '')) }}>
                                                        <span class="mr-3"> </span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="is_special">
                                                        Special offer?
                                                    </label><br>
                                                    <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary mb-2">
                                                        <input type="checkbox" value="1" name="is_special"
                                                                {{ (!empty($row) && isset($row->is_special) && $row->is_special == 1 ? 'checked' : '') }}>
                                                        <span class="mr-3"> </span>
                                                    </label>
                                                </div>
                                            </div>

                                            @if(isset($row) && $row->is_special)
                                                <div class="col-md-12">
                                                    <div class="alert alert-light border mb-0">
                                                        <label class="d-block font-weight-bold mb-2">Public slider link</label>
                                                        <p class="small text-muted mb-2">Opens the site Offers page and selects this special offer in the slider. Share this URL in campaigns.</p>
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control" id="manage-offer-special-url" readonly
                                                                   value="{{ route('site.offers', ['special' => $row->slug]) }}">
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-outline-secondary" id="manage-offer-special-copy">Copy</button>
                                                                <a href="{{ route('site.offers', ['special' => $row->slug]) }}" target="_blank" rel="noopener"
                                                                   class="btn btn-outline-primary">Open</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
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
            function toggleOfferBookNowMode() {
                var useBookNow = $('input.offer-slider-btn-mode:checked').val() === '1';
                $('.offer-book-now-single').toggle(!useBookNow);
                $('.offer-book-now-by-country').toggle(useBookNow);
            }
            toggleOfferBookNowMode();
            $('input.offer-slider-btn-mode').on('change', toggleOfferBookNowMode);

            var rowIndex = {{ isset($row) ? max(count($row->getBookNowUrl()), 1) : 1 }};

            $(document).on('click', '.add-offer-book-now-row', function () {
                var $originalRow = $(this).closest('.offer-book-now-row');
                var $newRow = $originalRow.clone();
                $newRow.find('select, input').each(function () {
                    var name = $(this).attr('name');
                    if (name) {
                        var updatedName = name.replace(/\[\d+\]/, '[' + rowIndex + ']');
                        $(this).attr('name', updatedName);
                    }
                    if ($(this).is('input')) {
                        $(this).val('');
                    }
                });
                $newRow.find('.add-offer-book-now-row').addClass('d-none');
                $newRow.find('.remove-offer-book-now-row').removeClass('d-none');
                $('#offer-book-now-container').append($newRow);
                rowIndex++;
            });

            $(document).on('click', '.remove-offer-book-now-row', function () {
                $(this).closest('.offer-book-now-row').remove();
            });

            $(document).on('click', '#manage-offer-special-copy', function () {
                var el = document.getElementById('manage-offer-special-url');
                if (!el || !navigator.clipboard) return;
                navigator.clipboard.writeText(el.value).then(function () {
                    if (typeof toastr !== 'undefined') {
                        toastr.success('Link copied');
                    }
                });
            });

            $(document).on('click', '.offer-admin-pdf-preview-btn', function () {
                var url = $(this).data('pdf-url');
                var $frame = $(this).parent().find('.offer-admin-pdf-preview-frame');
                if (!url || !$frame.length) return;
                $frame.show().html('<iframe title="PDF preview" class="w-100 border-0" style="height: 200px;" src="' + url + '#view=FitH"></iframe>');
            });
        });
    </script>
@endpush

