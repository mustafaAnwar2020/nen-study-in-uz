@extends('admin.layouts.admin_dashboard', ['title'=>$model, 'hasEditor' => true])

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
                                <form action="{{route('admin.blogs.store')}}" method="post" id="form"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="row_id" value="{{isset($row) ? $row->id : ''}}">

                                    <div class="modal-body">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input id="title" class="form-control" name="title"
                                                           value="{{isset($row) ? $row->title : old('title')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="slug">Slug</label>
                                                    <input id="slug" class="form-control" name="slug"
                                                           value="{{isset($row) ? $row->slug : old('slug')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select id="status" class="form-control" name="status">
                                                        @foreach(\App\Models\Blog::getStatuses() as $value => $label)
                                                            <option value="{{ $value }}"
                                                                {{ (isset($row) && $row->status == $value) ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="image">
                                                        Image
                                                        @if(isset($row) && $row->image)
                                                            <a href="{{ asset($row->image) }}" target="_blank" rel="noopener">Open <i class="fa fa-eye"></i></a>
                                                        @endif
                                                    </label>
                                                    <x-file-upload class="form-control" data-folder="blogs" name="image-file"/>
                                                    @if(isset($row) && $row->image)
                                                        <div class="mt-2 border rounded p-1 bg-light">
                                                            <img src="{{ asset($row->image) }}" alt="" class="img-fluid" style="max-height: 120px;">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="article">Article</label>
                                                    <div data-tiny-editor data-input="article">{!! isset($row) ? $row->article : old('article') !!}</div>
                                                    <input type="hidden" name="article" id="article">
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
