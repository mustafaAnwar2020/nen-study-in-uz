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
                                    {{$gov ?? ''}}
                                    -
                                    {{$model}}
                                    -
                                    القري
                                </h3>

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
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($villages as $idx=>$village)
                                        <tr>
                                            <td>{{$idx+1}}</td>
                                            <td class="text-center">{{$village->name}}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="destroy('{{route('admin.set_locations.delete_village', $village->id)}}', 'هل أنت متأكد من الحذف؟')"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>
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


    @include('admin.settings.locations.create-village')

@endsection
