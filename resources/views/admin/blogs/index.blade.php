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

                                @if(request()->routeIs('admin.blogs.index'))
                                <a href="{{route('admin.blogs.create')}}" class="btn btn-sm btn-dark mr-2 float-right">
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
                                        <th class="text-center">Title</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Active</th>
                                        <th class="text-center">Date created</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $idx=>$row)
                                        <tr>
                                            <td>{{ $rows->firstItem() + $idx }}</td>
                                            <td class="text-center">{{ $row->title }}</td>
                                            <td class="text-center">{!! $row->getStatusLabel() !!}</td>
                                            <td class="text-center">
                                                <img src="{{ $row->getImage() }}" width="40" alt="">
                                            </td>
                                            <td class="text-center">
                                                @if($row->is_active)
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-secondary">No</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $row->created_at->format('Y-m-d') }}</td>
                                            <td class="text-center text-nowrap">
                                                <a href="{{route('admin.blogs.edit', $row->slug)}}"
                                                   class="btn btn-dark btn-sm">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <button type="button"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="destroy('{{ route('admin.blogs.delete', $row->id) }}', 'Delete this blog?')">
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

@endsection
