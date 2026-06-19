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
                                <h3 class="card-title">  {{$model}}</h3>
                            </div>

                            <div class="card-body p-0 table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th class="text-center">اسم</th>
{{--                                        <th class="text-center">تفعيل</th>--}}
                                        <th class="text-center">المراكز والقري</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($governorates as $idx=>$governorate)
                                        <tr>
                                            <td>{{$idx+1}}</td>
                                            <td class="text-center">{{$governorate->governorate_name_ar}}</td>
                                            {{--<td class="text-center">
                                                <input type="checkbox" name="is_active"
                                                       class="bootstrap_switch"
                                                       {{($governorate->is_active) ? 'checked' : ''}}
                                                       onchange="updateIsActive({{$governorate->id}}, 'gov')"
                                                       data-bootstrap-switch data-off-color="danger"
                                                       data-on-text="{{__('admin_dashboard.common.activate')}}"
                                                       data-off-text="{{__('admin_dashboard.common.activate')}}"
                                                       data-on-color="success">
                                            </td>--}}
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-info"
                                                   href="{{route('admin.set_locations.sub', $governorate->id)}}">
                                                    عرض
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
