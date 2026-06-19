@extends('admin.layouts.admin_dashboard', ['title'=>$model, 'hasEditor'=> true])

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
                                <form action="{{route('admin.faqs.store')}}" method="post" id="form"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="row_id" value="{{isset($row) ? $row->id : ''}}">

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Question</label>
                                                    <input id="name" class="form-control" name="name"
                                                           value="{{isset($row) ? $row->name : old('name')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="product_type">Product type</label>
                                                    <select id="product_type" class="form-control" name="product_type">
                                                        @foreach(\App\Models\Product::TYPES as $typeKey => $typeLabel)
                                                            <option
                                                                    {{ (isset($row) && $row->product_type === $typeKey) ? 'selected' : '' }}
                                                                    value="{{ $typeKey }}">{{ $typeLabel }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="answer">Answer</label>
                                                    <div data-tiny-editor data-input="answer">{!! isset($row) ? $row->answer : old('answer') !!}</div>
                                                </div>
                                                <input type="hidden" name="answer" id="answer">
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
                                                    <x-file-upload class="form-control" data-folder="faqs"
                                                                   name="image-file"/>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="show_in_home" id="show_in_home" value="1"
                                                            {{ (isset($row) && $row->show_in_home) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="show_in_home">Show on home page</label>
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



