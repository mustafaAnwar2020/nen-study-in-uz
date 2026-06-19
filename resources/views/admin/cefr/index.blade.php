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

                                <a href="{{route('admin.cefr.create')}}" class="btn btn-sm btn-dark mr-2 float-right">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0 table-responsive">
                                <table class="dataTableRows table table-bordered table-hover">
                                    <thead class="bg-gradient-gray">
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th class="text-center">Title</th>
                                        <th class="text-center">Content Type</th>
                                        <th class="text-center">Order</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Date created</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $idx=>$row)
                                        <tr>
                                            <td>{{$idx+1}}</td>
                                            <td class="text-center">{{$row->title }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-{{$row->content_type == 'text' ? 'primary' : ($row->content_type == 'table' ? 'info' : 'warning')}}">
                                                    {{ucfirst($row->content_type)}}
                                                </span>
                                            </td>
                                            <td class="text-center">{{$row->order_number}}</td>
                                            <td class="text-center">
                                                <span class="badge badge-{{$row->is_active ? 'success' : 'danger'}}">
                                                    {{$row->is_active ? 'Active' : 'Inactive'}}
                                                </span>
                                            </td>
                                            <td class="text-center">{{$row->created_at->format('Y-m-d')}}</td>
                                            <td class="text-center">
                                                <a href="{{route('admin.cefr.edit', $row->id)}}"
                                                   class="btn btn-dark btn-sm">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <form action="{{route('admin.cefr.destroy', $row->id)}}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
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

    @include('admin.cefr.filter')

@endsection