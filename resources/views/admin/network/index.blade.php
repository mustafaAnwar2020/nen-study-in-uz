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
                                <a href="{{route('admin.network.import')}}"
                                   class="btn btn-sm btn-dark mr-2 float-right">
                                    <i class="fa fa-upload"></i>
                                    Excel Import
                                </a>
                                <button class="btn btn-sm btn-primary mr-2 float-right"
                                        data-toggle="modal" data-target="#filter" title="Filter"
                                >
                                    <i class="fa fa-filter"></i>
                                </button>

                                <a href="{{route('admin.network.create')}}"
                                   class="btn btn-sm btn-dark mr-2 float-right">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0 table-responsive">
                                <table class="dataTableRows table table-bordered table-hover">
                                    <thead class="bg-gradient-gray">
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Country</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Date created</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $idx=>$row)
                                        <tr>
                                            <td>{{$idx+1}}</td>
                                            <td class="text-center">{{$row->name }}</td>
                                            <td class="text-center">
                                                {{ config('countries.'.$row->country_code)  }}
                                                <br>
                                                <span class="flag-icon flag-icon-{{$row->country_code}}"></span>
                                            </td>
                                            <td class="text-center">{{$row->email }}</td>
                                            <td class="text-center">{{$row->type }}</td>
                                            <td class="text-center">{{$row->created_at->format('Y-m-d')}}</td>
                                            <td class="text-center">

                                                <button
                                                        @if($row->is_active)
                                                        onclick="destroy('{{route('admin.change_status', ['model'=>'Network','model_id'=>$row->id, 'status'=>'inactive'])}}', 'Sure to deactivate?')"
                                                        @else
                                                        onclick="destroy('{{route('admin.change_status', ['model'=>'Network','model_id'=>$row->id, 'status'=>'active'])}}', 'Sure to activate?')"
                                                        @endif
                                                        class="btn btn-{{$row->is_active ? 'warning' : 'success'}} btn-sm">
                                                    <i class="fas fa-power-off"></i>
                                                </button>

                                                <a href="{{route('admin.network.edit', $row->slug)}}"
                                                   class="btn btn-dark btn-sm">
                                                    <i class="fas fa-pen"></i>
                                                </a>

                                                <button
                                                        onclick="destroy('{{route('admin.delete', ['model'=>'Network','model_id'=>$row->id])}}', 'Sure to delete this data?')"
                                                        class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>


                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                @include('includes.paginator', ['paginator' => $rows->appends(request()->all())])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('admin.network.filter')


@endsection

@push('push_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/4.1.5/css/flag-icons.min.css">
@endpush
