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
                                <form action="{{route('admin.events.store')}}" method="post" id="form"
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
                                                    <label for="slug">Slug</label>
                                                    <input id="slug" class="form-control" name="slug"
                                                           placeholder="e.g. ets-conference-namangan-2026"
                                                           value="{{ old('slug', isset($row) ? $row->slug : '') }}">
                                                    <small class="text-muted d-block mt-1">
                                                        Used in the public event URL. Lowercase letters, numbers, and hyphens only.
                                                        @if(old('slug', isset($row) ? $row->slug : ''))
                                                            Preview:
                                                            <a href="{{ route('site.events.show', old('slug', $row->slug ?? '')) }}" target="_blank" rel="noopener">
                                                                {{ route('site.events.show', old('slug', $row->slug ?? '')) }}
                                                            </a>
                                                        @endif
                                                    </small>
                                                    @error('slug')
                                                        <small class="text-danger d-block">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="country_code">Country</label>
                                                    <select id="country_code" class="form-control" name="country_code">
                                                        @foreach(config('countries') as $code=>$country)
                                                            <option
                                                                    {{ (isset($row) && $row->country_code == $code)  ? 'selected' : ''  }}
                                                                    value="{{$code}}">{{$country}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="book_now_url">Book Now URL</label>
                                                    <input id="book_now_url" class="form-control" name="book_now_url"
                                                           value="{{isset($row) ? $row->book_now_url : old('book_now_url')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="date">Date</label>
                                                    <input id="date" type="date" class="form-control" name="date"
                                                           value="{{isset($row) ? $row->date : old('date')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="time">Time</label>
                                                    <input id="time" type="text" class="form-control" name="time"
                                                           placeholder="Like: 5 hrs"
                                                           value="{{isset($row) ? $row->time : old('time')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="location">Location</label>
                                                    <input id="location" type="text" class="form-control"
                                                           name="location"
                                                           placeholder="Google maps link or address"
                                                           value="{{isset($row) ? $row->location : old('location')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="address">Address</label>
                                                    <input id="address" type="text" class="form-control"
                                                           name="address"
                                                           value="{{isset($row) ? $row->address : old('address')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="excel_file">
                                                        Excel file
                                                        @if(isset($row) && $row->excel_file)
                                                            <a href="{{$row->excel_file}}" target="_blank">
                                                                show
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endif

                                                    </label>
                                                    <x-file-upload class="form-control" data-folder="events"
                                                                   name="excel_file-file"/>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="image">
                                                        Image
                                                        @if(isset($row) && $row->image)
                                                            <a href="{{$row->image}}" target="_blank">
                                                                show
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endif

                                                    </label>
                                                    <x-file-upload class="form-control" data-folder="events"
                                                                   name="image-file"/>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="event-pdf-upload">PDF</label>
                                                    <small class="d-block text-muted mb-1">Max ~20 MB</small>
                                                    <x-file-upload
                                                        class="form-control"
                                                        data-folder="events"
                                                        name="pdf-file"
                                                        accept=".pdf"
                                                        data-upload-kind="event_pdf"
                                                        data-max-kb="20480"
                                                        data-allowed-ext="pdf"
                                                    />
                                                    @if(isset($row) && $row->pdf)
                                                        <div class="mt-2 border rounded p-2 bg-light">
                                                            <p class="small text-muted mb-2">Preview loads only when you choose an action.</p>
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

                                            @include('admin.events.partials.landing-page-fields')

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="show_full_address">Show full address on site?</label><br>
                                                    <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary mb-2">
                                                        <input type="checkbox" value="1" name="show_full_address"
                                                                {{ (!empty($row) && $row->show_full_address) ? 'checked' : '' }}>
                                                        <span class="mr-3"> </span>
                                                    </label>
                                                    <small class="d-block text-muted">When on, the street address is shown together with the country on on-site events.</small>
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


@push('scripts')
    <script>
        $(function () {
            $(document).on('click', '.offer-admin-pdf-preview-btn', function () {
                var url = $(this).data('pdf-url');
                var $frame = $(this).parent().find('.offer-admin-pdf-preview-frame');
                if (!url || !$frame.length) return;
                $frame.show().html('<iframe title="PDF preview" class="w-100 border-0" style="height: 200px;" src="' + url + '#view=FitH"></iframe>');
            });
        });
    </script>
@endpush

@endsection



