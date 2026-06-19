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
                                <form action="{{ route('admin.products.store') }}" method="post" id="form"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="row_id" value="{{ isset($row) ? $row->id : '' }}">

                                    <div class="modal-body">
                                        <div class="row">

                                            {{-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="category_id">Category</label>
                                                    <select class="form-control" name="category_id" id="category_id">
                                                        @foreach (\App\Models\ProductCategory::active()->get() as $cat)
                                                            <option
                                                                    {{ (isset($row) && $row->category_id == $cat->id)  ? 'selected' : ''  }}
                                                                    value="{{$cat->id}}">{{$cat->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> --}}

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input id="name" class="form-control" name="name"
                                                        value="{{ isset($row) ? $row->name : old('name') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="url">URL</label>
                                                    <input id="url" class="form-control" name="url"
                                                        value="{{ isset($row) ? $row->url : old('url') }}">
                                                </div>
                                            </div>

                                            {{-- <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="book_now_url">Book Now URL</label>
                                                     <input id="book_now_url" class="form-control" name="book_now_url"
                                                            value="{{isset($row) ? $row->book_now_url : old('book_now_url')}}">
                                                 </div>
                                             </div> --}}


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="more_link">Know More URL</label>
                                                    <input id="more_link" class="form-control" name="more_link"
                                                        value="{{ isset($row) ? $row->more_link : old('more_link') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="type">Type</label>
                                                    <select id="type" class="form-control" name="type"
                                                        onchange="checkType(this.value)">
                                                        @foreach (\App\Models\Product::TYPES as $idx => $type)
                                                            <option
                                                                {{ isset($row) && $row->type == $idx ? 'selected' : '' }}
                                                                value="{{ $idx }}">{{ $type }}</option>
                                                        @endforeach
                                                    </select>
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
                                                    <x-file-upload class="form-control" data-folder="products"
                                                        name="image-file" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="is_active">Status</label>
                                                    <select class="form-control" name="is_active" id="is_active">
                                                        <option value="1"
                                                            {{ isset($row) && $row->is_active == 1 ? 'selected' : '' }}>
                                                            Active</option>
                                                        <option value="0"
                                                            {{ isset($row) && $row->is_active == 0 ? 'selected' : '' }}>
                                                            Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="show_in_home">Show in Home Page</label>
                                                    <select class="form-control" name="show_in_home" id="show_in_home">
                                                        <option value="1"
                                                            {{ isset($row) && $row->show_in_home == 1 ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="0"
                                                            {{ (isset($row) && $row->show_in_home == 0) || !isset($row) ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </div>
                                            </div>


                                            {{-- <div class="col-md-6 country_list_file"
                                                 style="display:{{isset($row) && $row->type == 'assessment' ? '' : 'none'}};">
                                                <div class="form-group">
                                                    <label for="image">
                                                        Country list file
                                                        @if (isset($row) && $row->country_list_file)
                                                            <a href="{{$row->country_list_file}}" target="_blank">
                                                                show
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endif

                                                    </label>
                                                    <x-file-upload class="form-control" data-folder="products"
                                                                   name="country_list_file-file"/>
                                                </div>
                                            </div> --}}

                                            <div class="col-md-6 become_partner_url"
                                                style="display:{{ isset($row) && $row->type == 'assessment' ? '' : 'none' }};">
                                                <div class="form-group">
                                                    <label for="become_partner_url">Become Partner URL</label>
                                                    <input id="become_partner_url" class="form-control"
                                                        name="become_partner_url"
                                                        value="{{ isset($row) ? $row->become_partner_url : old('become_partner_url') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="book_now_url">Book Now URL</label>
                                                    <div id="book-now-container">
                                                        @php
                                                            $bookNowUrls = isset($row) ? $row->getBookNowUrl() : [];
                                                        @endphp


                                                        @forelse($bookNowUrls as $index => $entry)
                                                            <div class="row mb-2 book-now-row">
                                                                <div class="col-md-4">
                                                                    <select class="form-control country-code"
                                                                        name="book_now_url[{{ $index }}][country]">
                                                                        @foreach (config('countries') as $code => $country)
                                                                            <option value="{{ $code }}"
                                                                                {{ $entry->country === $code ? 'selected' : '' }}>
                                                                                {{ $country }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="url" class="form-control url"
                                                                        name="book_now_url[{{ $index }}][url]"
                                                                        value="{{ $entry->url }}"
                                                                        placeholder="Enter URL">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button type="button"
                                                                        class="btn btn-success add-book-now-row {{ $loop->last ? '' : 'd-none' }}">
                                                                        +
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-danger remove-book-now-row {{ $loop->first ? 'd-none' : '' }}">
                                                                        -
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="row mb-2 book-now-row">
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
                                                                        class="btn btn-success add-book-now-row">+
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-danger remove-book-now-row d-none">
                                                                        -
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea id="description" rows="3" class="form-control" name="description">{{ isset($row) ? $row->description : old('description') }}</textarea>
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
        function checkType(type) {
            if (type == 'assessment') {
                //$('.country_list_file').show();
                $('.become_partner_url').show();
            } else {
                //$('.country_list_file').hide();
                $('.become_partner_url').hide();
            }
        }

        $(document).ready(function() {
            let rowIndex =
                {{ isset($row) ? (is_array($row->getBookNowUrl()) ? count($row->getBookNowUrl()) : count(get_object_vars($row->getBookNowUrl()))) : 1 }};


            // Add new row
            $(document).on('click', '.add-book-now-row', function() {
                const $originalRow = $(this).closest('.book-now-row');
                const $newRow = $originalRow.clone();

                // Update the name attributes for the cloned inputs
                $newRow.find('select, input').each(function() {
                    const name = $(this).attr('name');
                    if (name) {
                        const updatedName = name.replace(/\[\d+\]/, `[${rowIndex}]`);
                        $(this).attr('name', updatedName);
                    }
                    $(this).val(''); // Clear the value for new inputs
                });

                // Adjust buttons
                $newRow.find('.add-book-now-row').addClass('d-none');
                $newRow.find('.remove-book-now-row').removeClass('d-none');

                $('#book-now-container').append($newRow);
                rowIndex++;
            });

            // Remove row
            $(document).on('click', '.remove-book-now-row', function() {
                $(this).closest('.book-now-row').remove();
            });
        });
    </script>
@endpush
