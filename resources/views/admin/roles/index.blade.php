@extends('admin.layouts.admin_dashboard', ['title' => $model])

@section('content')
    <div class="content-wrapper">
        @include('admin.layouts.breadcrumb', ['model' => $model])
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $model }}</h3>
                                <a class="btn btn-sm btn-success mr-2 float-right"
                                   href="{{ route('admin.roles.create') }}"><i class="fa fa-plus"></i></a>
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="dataTableRows table table-bordered table-hover">
                                    <thead class="bg-gradient-gray">
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Arabic Name</th>
                                        <th class="text-center">Users Count</th>
                                        <th class="text-center">Permissions Count</th>
                                        <th class="text-center">System Role</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($rows as $idx => $row)
                                        <tr>
                                            <td>{{ $rows->firstItem() + $idx }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->name_ar ?? '---' }}</td>
                                            <td class="text-center">{{ $row->users_count }}</td>
                                            <td class="text-center">{{ $row->permissions_count }}</td>
                                            <td class="text-center">
                                                @if($row->is_system)
                                                    <span class="badge badge-info">Yes</span>
                                                @else
                                                    <span class="badge badge-secondary">No</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.roles.edit', $row->id) }}"
                                                   class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @if(!$row->is_system)
                                                    <a href="javascript:;" onclick="destroy('{{ route('admin.roles.delete', $row->id) }}', 'Are you sure?')"
                                                       class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="7">No data available</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                @include('includes.paginator', ['paginator' => $rows])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
