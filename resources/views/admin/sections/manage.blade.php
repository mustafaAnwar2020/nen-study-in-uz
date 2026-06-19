@extends('admin.layouts.admin_dashboard', ['title' => $model, 'hasEditor' => true])

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
                                <form action="{{ route('admin.sections.update', $row->slug) }}" method="post" id="form"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input id="title" class="form-control" name="title"
                                                        value="{{ isset($row) ? $row->title : old('title') }}">
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <div data-tiny-editor data-input="description">{!! isset($row) ? $row->description : old('description') !!}
                                                    </div>
                                                </div>
                                                <input type="hidden" name="description" id="description">
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="btn_text">Button Title</label>
                                                    <input id="btn_text" class="form-control" name="btn_text"
                                                        value="{{ isset($row) ? $row->btn_text : old('btn_text') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="btn_url">Button Url</label>
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

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="iframe_url">Iframe Url</label>
                                                    <input id="iframe_url" class="form-control" name="iframe_url"
                                                        value="{{ isset($row) ? $row->iframe_url : old('iframe_url') }}">
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

                                            <!-- List Editing Section -->
                                            @if (isset($row) && !empty($row->getList()))
                                                <div class="col-md-12">
                                                    <h4>Edit List</h4>
                                                    Choose from bi icons <a href="https://icons.getbootstrap.com/"
                                                        target="_blank">Bootstrap Icons</a>
                                                    @foreach ($row->getList() as $index => $item)
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="icon_{{ $index }}">Icon</label>
                                                                <input id="icon_{{ $index }}" class="form-control"
                                                                    name="list[{{ $index }}][icon]"
                                                                    value="{{ $item->icon }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="title_{{ $index }}">Title</label>
                                                                <input id="title_{{ $index }}" class="form-control"
                                                                    name="list[{{ $index }}][title]"
                                                                    value="{{ $item->title }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="desc_{{ $index }}">Description</label>
                                                                <textarea id="desc_{{ $index }}" class="form-control" rows="3" name="list[{{ $index }}][desc]">{{ $item->desc }}</textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="btn_text_{{ $index }}">Button
                                                                    Title</label>
                                                                <input id="btn_text_{{ $index }}"
                                                                    class="form-control"
                                                                    name="list[{{ $index }}][btn_text]"
                                                                    value="{{ $item->btn_text ?? '' }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="btn_url_{{ $index }}">Button
                                                                    Url</label>
                                                                <input id="btn_url_{{ $index }}"
                                                                    class="form-control"
                                                                    name="list[{{ $index }}][btn_url]"
                                                                    value="{{ $item->btn_url ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="col-md-12">
                                                    <p>No list items found.</p>
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
