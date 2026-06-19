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
                                <div class="float-right">
                                    <a class="btn btn-sm btn-info mr-1"
                                       href="{{ route('admin.permissions.sync-default') }}"
                                       onclick="return confirm('This will sync all default permissions. Continue?')">
                                        <i class="fa fa-sync"></i> Sync Defaults
                                    </a>
                                    <a class="btn btn-sm btn-success"
                                       href="{{ route('admin.permissions.create') }}"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="dataTableRows table table-bordered table-hover">
                                    <thead class="bg-gradient-gray">
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Arabic Name</th>
                                        <th>Group</th>
                                        <th class="text-center">Roles Count</th>
                                        <th class="text-center">Users (Direct)</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($rows as $idx => $row)
                                        <tr>
                                            <td>{{ $rows->firstItem() + $idx }}</td>
                                            <td><code>{{ $row->name }}</code></td>
                                            <td>{{ $row->name_ar ?? '---' }}</td>
                                            <td>
                                                @if($row->group)
                                                    <span class="badge badge-info">{{ $groups[$row->group] ?? $row->group }}</span>
                                                @else
                                                    <span class="badge badge-secondary">Other</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $row->roles_count }}</td>
                                            <td class="text-center">{{ $row->users_count }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.permissions.edit', $row->id) }}"
                                                   class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
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
