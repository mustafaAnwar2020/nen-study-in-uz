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
                                <form action="{{route('admin.network.store')}}" method="post" id="form"
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
                                                    <label for="status">Status</label>
                                                    <select id="status" class="form-control" name="status">
                                                        <option {{isset($row) && $row->status == 'active' ? 'selected' : ''}} value="active">
                                                            Active
                                                        </option>

                                                        <option {{isset($row) && $row->status == 'inactive' ? 'selected' : ''}} value="inactive">
                                                            InActive
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
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


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="city">City</label>
                                                    <input id="city" class="form-control" name="city"
                                                           value="{{isset($row) ? $row->city : old('city')}}">
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="type">Type</label>
                                                    <select id="type" class="form-control" name="type">
                                                        @foreach(\App\Models\Network::TYPES as $key=>$value)
                                                            <option
                                                                    {{isset($row) && $row->type == $key ? 'selected' : ''}}
                                                                    value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="id_text">ID</label>
                                                    <input id="id_text" class="form-control" name="id_text"
                                                           value="{{isset($row) ? $row->id_text : old('id_text')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="address">Address</label>
                                                    <input id="address" class="form-control" name="address"
                                                           value="{{isset($row) ? $row->address : old('address')}}">
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input id="email" class="form-control" name="email"
                                                           value="{{isset($row) ? $row->email : old('email')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone">Phone</label>
                                                    <input id="phone" class="form-control" name="phone"
                                                           value="{{isset($row) ? $row->phone : old('phone')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="position">Level</label>
                                                    <input id="position" class="form-control" name="position" required
                                                           value="{{isset($row) ? $row->position : old('position')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="social_media">Social media</label>
                                                    <input id="social_media" class="form-control" name="social_media"
                                                           required
                                                           value="{{isset($row) ? $row->social_media : old('social_media')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="since">Since</label>
                                                    <input id="since" class="form-control" name="since" required
                                                           value="{{isset($row) ? $row->since : old('since')}}">
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
                                                    <x-file-upload class="form-control" data-folder="network"
                                                                   name="image-file"/>
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



