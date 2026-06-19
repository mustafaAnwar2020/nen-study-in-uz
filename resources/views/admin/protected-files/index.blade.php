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

                                <a href="{{route('admin.protected-files.passwords')}}" class="btn btn-sm btn-warning mr-2 float-right">
                                    <i class="fa fa-key"></i> Passwords
                                </a>

                                <a href="{{route('admin.protected-files.create')}}" class="btn btn-sm btn-dark mr-2 float-right">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0 table-responsive">
                                <div class="alert alert-info m-2">
                                    <i class="fa fa-link"></i>
                                    <strong>Shareable public link:</strong>
                                    <a href="{{ route('protected-files.index') }}" target="_blank">{{ route('protected-files.index') }}</a>
                                </div>
                                <table class="dataTableRows table table-bordered table-hover">
                                    <thead class="bg-gradient-gray">
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">File Path</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Last Accessed</th>
                                        <th class="text-center">Date Created</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $idx=>$row)
                                        <tr>
                                            <td>{{$idx+1}}</td>
                                            <td class="text-center">{{$row->name }}</td>
                                            <td class="text-center">
                                                <code>{{$row->file_path }}</code>
                                            </td>
                                            <td class="text-center">
                                                {{Str::limit($row->description, 50) }}
                                            </td>
                                            <td class="text-center">
                                                @if($row->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($row->last_accessed)
                                                    {{$row->last_accessed->format('Y-m-d H:i')}}
                                                @else
                                                    <span class="text-muted">Never</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{$row->created_at->format('Y-m-d')}}</td>
                                            <td class="text-center">
                                                <a href="{{route('admin.protected-files.edit', $row->id)}}"
                                                   class="btn btn-dark btn-sm" title="Edit">
                                                    <i class="fas fa-pen"></i>
                                                </a>                                            

                                                <form method="POST" action="{{route('admin.protected-files.destroy', $row->id)}}" 
                                                      style="display: inline-block;" 
                                                      onsubmit="return confirm('Are you sure you want to delete this protected file?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
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

    @include('admin.protected-files.filter')

@endsection