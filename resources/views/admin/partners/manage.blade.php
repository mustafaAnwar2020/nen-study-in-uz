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

                            <div class="card-body p-0">
                                <form action="{{route('admin.partners.store')}}" method="post" id="form"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="row_id" value="{{isset($row) ? $row->id : ''}}">

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input id="name" class="form-control" name="name" required
                                                           value="{{isset($row) ? $row->name : old('name')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="country_code">Country</label>
                                                    <select id="country_code" class="form-control" name="country_code">
                                                        @foreach(config('countries') as $idx=>$country)
                                                            <option
                                                                    {{isset($row) && $row->country_code == $idx ? 'selected' : ''}}
                                                                    value="{{$idx}}">{{$country}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="product_id">Product</label>
                                                    <select id="product_id" class="form-control" name="product_id">
                                                        @foreach(\App\Models\Product::query()->where('type', \App\Models\Product::TYPES['assessment'])->get() as $product)
                                                            <option
                                                                    {{isset($row) && $row->product_id == $product->id ? 'selected' : ''}}
                                                                    value="{{$product->id}}">{{$product->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="website">Website</label>
                                                    <input id="website" class="form-control" name="website"
                                                           value="{{isset($row) ? $row->website : old('website')}}">
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="image">
                                                        Logo
                                                        @if(isset($row) && $row->logo)
                                                            <a href="{{$row->logo}}" target="_blank">
                                                                show
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endif

                                                    </label>
                                                    <x-file-upload class="form-control" data-folder="partners"
                                                                   name="logo-file"/>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="image">
                                                        PDF
                                                        @if(isset($row) && $row->pdf)
                                                            <a href="{{$row->pdf}}" target="_blank">
                                                                show
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endif

                                                    </label>
                                                    <x-file-upload class="form-control" data-folder="partners"
                                                                   name="pdf-file"/>
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



