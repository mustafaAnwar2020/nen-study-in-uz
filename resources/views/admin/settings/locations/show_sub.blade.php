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
                                <h3 class="card-title">
                                    المراكز -
                                    {{$model}}</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#create">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body p-0 table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th class="text-center">اسم</th>
{{--                                        <th class="text-center">تفعيل</th>--}}
                                        <th class="text-center"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cities as $idx=>$city)
                                        <tr>
                                            <td>{{$idx+1}}</td>
                                            <td class="text-center">{{$city->city_name_ar}}</td>
                                           {{-- <td class="text-center">
                                                <input type="checkbox" name="is_active"
                                                       class="bootstrap_switch"
                                                       {{($city->is_active) ? 'checked' : ''}}
                                                       onchange="updateIsActive({{$city->id}}, 'city')"
                                                       data-bootstrap-switch data-off-color="danger"
                                                       data-on-text="{{__('admin_dashboard.common.activate')}}"
                                                       data-off-text="{{__('admin_dashboard.common.activate')}}"
                                                       data-on-color="success">
                                            </td>--}}
                                            <td class="text-center">
                                                <a href="{{route('admin.set_locations.show_villages', $city->id)}}"
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

    @include('admin.settings.locations.create-city')


@endsection

@section('scripts')

    <script>
        function updateIsActive(id, type) {
            $.ajax({
                url: '{{route('admin.set_locations.update_status')}}',
                type: 'post',
                data: {
                    _token: "{{csrf_token()}}",
                    id,
                    type
                },
            });
        }
    </script>

@endsection
