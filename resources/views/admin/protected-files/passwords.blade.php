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
                                <a href="{{route('admin.protected-files.index')}}" class="btn btn-sm btn-secondary float-right">
                                    <i class="fa fa-arrow-left"></i> Back to Files
                                </a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0 table-responsive">
                                <table class="dataTableRows table table-bordered table-hover">
                                    <thead class="bg-gradient-gray">
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th class="text-center">File Name</th>
                                        <th class="text-center">File Path</th>
                                        <th class="text-center">Current Password</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Last Accessed</th>
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
                                <div class="password-field" id="password-{{$row->id}}">
                                    <span class="password-hidden">••••••••</span>
                                    <button type="button" class="btn btn-sm btn-outline-secondary ml-2" 
                                            onclick="togglePassword({{$row->id}})">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <span class="password-visible" style="display: none;">
                                        <strong>{{$row->plain_password ?? 'Password not available'}}</strong>
                                    </span>
                                </div>
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
                                            <td class="text-center">
                                                <button type="button" class="btn btn-warning btn-sm" 
                                                        data-toggle="modal" data-target="#changePasswordModal{{$row->id}}"
                                                        title="Change Password">
                                                    <i class="fas fa-key"></i>
                                                </button>
                                                
                                                <a href="{{route('admin.protected-files.edit', $row->id)}}"
                                                   class="btn btn-dark btn-sm" title="Edit File">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Change Password Modal -->
                                        <div class="modal fade" id="changePasswordModal{{$row->id}}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Change Password for: {{$row->name}}</h5>
                                                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                    <form action="{{route('admin.protected-files.update-password', $row->id)}}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="password{{$row->id}}">New Password</label>
                                                                <input type="password" class="form-control" 
                                                                       id="password{{$row->id}}" name="password" 
                                                                       required minlength="6">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="password_confirmation{{$row->id}}">Confirm Password</label>
                                                                <input type="password" class="form-control" 
                                                                       id="password_confirmation{{$row->id}}" 
                                                                       name="password_confirmation" required minlength="6">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-warning">
                                                                <i class="fa fa-key"></i> Update Password
                                                            </button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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

@section('scripts')
<script>
function togglePassword(id) {
    const passwordField = document.getElementById('password-' + id);
    const hiddenSpan = passwordField.querySelector('.password-hidden');
    const visibleSpan = passwordField.querySelector('.password-visible');
    const button = passwordField.querySelector('button i');
    
    if (hiddenSpan.style.display === 'none') {
        hiddenSpan.style.display = 'inline';
        visibleSpan.style.display = 'none';
        button.className = 'fa fa-eye';
    } else {
        hiddenSpan.style.display = 'none';
        visibleSpan.style.display = 'inline';
        button.className = 'fa fa-eye-slash';
    }
}
</script>
@endsection