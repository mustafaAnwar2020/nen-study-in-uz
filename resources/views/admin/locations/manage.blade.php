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
                                <form action="{{route('admin.locations.store')}}" method="post" id="form"
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
                                    <label for="location_type">Location Type</label>
                                    <select id="location_type" class="form-control" name="location_type" required>
                                        <option value="Main Offices" {{isset($row) && $row->location_type == 'Main Offices' ? 'selected' : (old('location_type') == 'Main Offices' ? 'selected' : (!isset($row) && !old('location_type') ? 'selected' : ''))}}>Main Offices</option>
                                        <option value="Authorized Offices" {{isset($row) && $row->location_type == 'Authorized Offices' ? 'selected' : (old('location_type') == 'Authorized Offices' ? 'selected' : '')}}>Authorized Offices</option>
                                    </select>
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
                                                    <label for="address">Address</label>
                                                    <input id="address" class="form-control" name="address"
                                                           value="{{isset($row) ? $row->address : old('address')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="land_line">Land line</label>
                                                    <input id="land_line" class="form-control" name="land_line"
                                                           value="{{isset($row) ? $row->land_line : old('land_line')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="call_center">Call Center</label>
                                                    <input id="call_center" class="form-control" name="call_center"
                                                           value="{{isset($row) ? $row->call_center : old('call_center')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input id="email" class="form-control" name="email"
                                                           value="{{isset($row) ? $row->email : old('email')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phone">Phone</label>
                                                    <input id="phone" class="form-control" name="phone"
                                                           value="{{isset($row) ? $row->phone : old('phone')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="schedule">Schedule</label>
                                                    <input id="schedule" class="form-control" name="schedule"
                                                           placeholder="Mon-Fri, 9 AM - 5 PM"
                                                           value="{{isset($row) ? $row->schedule : old('schedule')}}">
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="map_url">Map Url</label>
                                                    <input id="map_url" class="form-control" name="map_url" required
                                                           value="{{isset($row) ? $row->map_url : old('map_url')}}" placeholder="https://www.google.com/maps/place/NEN+%7C+NATIONAL+EDUCATION+NETWORK+-+MUSCAT+-+OMAN+(OPT),+Al-Watan+Newspaper+Building,+West+Wing,+405">
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
                                                    <x-file-upload class="form-control" data-folder="locations"
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



