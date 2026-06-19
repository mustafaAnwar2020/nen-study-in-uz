@extends('admin.layouts.admin_dashboard', ['title' => $model])

@section('content')
    <div class="content-wrapper">
        @include('admin.layouts.breadcrumb', ['model' => $model])
        <section class="content">
            <div class="container-fluid">
                {{-- Filters --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Search & Filter</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="GET" action="{{ route('admin.users.index') }}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control"
                                                       placeholder="Name" value="{{ request('name') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="username" class="form-control"
                                                       placeholder="Username" value="{{ request('username') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select name="role_id" class="form-control">
                                                    <option value="">All Roles</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                                            {{ $role->name_ar ?? $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fa fa-search"></i> Search
                                            </button>
                                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-times"></i> Clear
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $model }}</h3>
                                <a class="btn btn-sm btn-success mr-2 float-right"
                                   href="{{ route('admin.users.create') }}"><i class="fa fa-plus"></i></a>
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="dataTableRows table table-bordered table-hover">
                                    <thead class="bg-gradient-gray">
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th class="text-center">Username</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($rows as $idx => $row)
                                        <tr>
                                            <td>{{ $rows->firstItem() + $idx }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td class="text-center">{{ $row->username }}</td>
                                            <td class="text-center">{{ $row->email ?? '---' }}</td>
                                            <td class="text-center">
                                                @if($row->roles->isNotEmpty())
                                                    <span class="badge badge-info">{{ $row->roles->first()->name_ar ?? $row->roles->first()->name }}</span>
                                                @else
                                                    <span class="badge badge-secondary">No Role</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.users.edit', $row->id) }}"
                                                   class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.users.permissions', $row->id) }}"
                                                   class="btn btn-sm btn-info" title="Permissions">
                                                    <i class="fa fa-shield-alt"></i>
                                                </a>
                                                @if(!$row->hasRole('super_admin') && $row->id != auth()->id())
                                                    <a href="javascript:;" onclick="destroy('{{ route('admin.users.delete', $row->id) }}', 'Are you sure?')"
                                                       class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="6">No data available</td>
                                        </tr>
                                    @endforelse
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
