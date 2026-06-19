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
                                <form action="{{route('admin.library.store')}}" method="post" id="form"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="row_id" value="{{isset($row) ? $row->id : ''}}">

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Title</label>
                                                    <input id="name" class="form-control" name="name"
                                                           value="{{isset($row) ? $row->name : old('name')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="url">URL</label>
                                                    <input id="url" class="form-control" name="url"
                                                           value="{{isset($row) ? $row->url : old('url')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="type">Type</label>
                                                    <select id="type" class="form-control" name="type"
                                                            onchange="checkType(this.value)">
                                                        @foreach(\App\Models\Library::TYPES as $idx=>$type)
                                                            <option
                                                                    {{ (isset($row) && $row->type == $idx)  ? 'selected' : ''  }}
                                                                    value="{{$idx}}">{{$type}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <input id="description" class="form-control" name="description"
                                                           value="{{isset($row) ? $row->description : old('description')}}">
                                                </div>
                                            </div>



                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="image">
                                                        File
                                                        @if(isset($row) && $row->file)
                                                            <a href="{{$row->file}}" target="_blank">
                                                                show
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endif

                                                    </label>
                                                    <x-file-upload class="form-control" data-folder="library"
                                                                   name="file-file"/>
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



