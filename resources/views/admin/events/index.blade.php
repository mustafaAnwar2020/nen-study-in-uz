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
                                <button class="btn btn-sm btn-primary mr-2 float-right"
                                        data-toggle="modal" data-target="#filter" title="Filter"
                                >
                                    <i class="fa fa-filter"></i>
                                </button>
                                @if(auth()->user()->hasRole('super_admin'))
                                    <a href="{{route('admin.events.create')}}" class="btn btn-sm btn-dark mr-2 float-right">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                @endif
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0 table-responsive">
                                <table class="dataTableRows table table-bordered table-hover">
                                    <thead class="bg-gradient-gray">
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Country</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Archived</th>
                                        <th class="text-center">Date created</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $idx=>$row)
                                        <tr>
                                            <td>{{$idx+1}}</td>
                                            <td class="text-center">{{$row->name }}</td>
                                            <td class="text-center">{{$row->date }}</td>
                                            <td class="text-center">
                                                {{ config('countries.'.$row->country_code)  }}
                                                <br>
                                                <span class="flag-icon flag-icon-{{$row->country_code}}"></span>
                                            </td>
                                            <td class="text-center">
                                                <img src="{{$row->getImage()}}" width="40" alt="">
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-{{$row->is_active == 1 ? 'success' : 'danger'}}">
                                                    {{$row->is_active == 1 ? 'Active' : 'Inactive'}}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-{{$row->archived ? 'secondary' : 'light'}}">
                                                    {{$row->archived ? 'Yes' : 'No'}}
                                                </span>
                                            </td>
                                            <td class="text-center">{{$row->created_at->format('Y-m-d')}}</td>
                                            <td class="text-center">


                                                <button
                                                        @if($row->is_active)
                                                        onclick="destroy('{{route('admin.change_status', ['model'=>'Event','model_id'=>$row->id, 'status'=>'inactive'])}}', 'Sure to deactivate?')"
                                                        @else
                                                        onclick="destroy('{{route('admin.change_status', ['model'=>'Event','model_id'=>$row->id, 'status'=>'active'])}}', 'Sure to activate?')"
                                                        @endif
                                                        class="btn btn-{{$row->is_active ? 'warning' : 'success'}} btn-sm">
                                                    <i class="fas fa-power-off"></i>
                                                </button>

                                                <a href="{{route('admin.events.edit', $row->slug)}}"
                                                   class="btn btn-dark btn-sm">
                                                    <i class="fas fa-pen"></i>
                                                </a>

                                                @if(auth()->user()->hasRole('super_admin'))
                                                <button
                                                        onclick="destroy('{{route('admin.delete', ['model'=>'Event','model_id'=>$row->id])}}', 'Sure to delete this data?')"
                                                        class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @endif
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

    @include('admin.events.filter')


@endsection

