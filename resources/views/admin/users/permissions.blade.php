@extends('admin.layouts.admin_dashboard', ['title' => $model])

@section('styles')
    <style>
        .perm-card {
            border: 1px solid #dee2e6;
            border-radius: 4px;
            margin-bottom: 12px;
        }
        .perm-card-header {
            background: #f4f6f9;
            padding: 8px 12px;
            border-bottom: 1px solid #dee2e6;
            font-weight: bold;
        }
        .perm-card-body {
            padding: 8px 12px;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        .perm-item {
            position: relative;
            flex: 0 0 auto;
        }
        .perm-item input[type="checkbox"] {
            display: none;
        }
        .perm-item label {
            display: inline-block;
            background: #eee;
            padding: 6px 16px;
            cursor: pointer;
            border-radius: 20px;
            font-size: 13px;
            transition: all 0.2s;
            user-select: none;
        }
        .perm-item input[type="checkbox"]:checked + label {
            background: #28a745;
            color: #fff;
        }
        .perm-item label.permission-through-role {
            background: #cce5ff;
            cursor: not-allowed;
            opacity: 0.85;
        }
        .perm-item input[type="checkbox"]:checked + label.permission-through-role {
            background: #007bff;
        }
        .info-note {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            padding: 10px 15px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        @include('admin.layouts.breadcrumb', ['model' => $model])
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Permissions for: <strong>{{ $user->name }}</strong>
                                    @if($user->roles->isNotEmpty())
                                        <span class="badge badge-info ml-2">{{ $user->roles->first()->name_ar ?? $user->roles->first()->name }}</span>
                                    @endif
                                </h3>
                                <div class="float-right">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="fa fa-arrow-left"></i> Back to User
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                @if($user->hasRole('super_admin'))
                                    <div class="alert alert-info">
                                        <i class="fa fa-info-circle"></i>
                                        Super Admin has all permissions. No changes needed.
                                    </div>
                                @else
                                    <div class="info-note">
                                        <i class="fa fa-info-circle"></i>
                                        <strong>Note:</strong>
                                        Permissions in blue are inherited from the role and cannot be directly revoked. Additional permissions in green are assigned directly to this user.
                                    </div>

                                    @php
                                        $rolePermissions = $user->roles->isNotEmpty() ? $user->roles->first()->permissions->pluck('id')->toArray() : [];
                                        $permissionGroups = \App\Services\AccessControlService::getPermissionGroups();
                                        $grouped = [];
                                        foreach ($all_permissions as $perm) {
                                            $g = $perm->group ?? 'other';
                                            $grouped[$g][] = $perm;
                                        }
                                    @endphp

                                    <div class="row">
                                        @foreach($grouped as $groupKey => $perms)
                                            <div class="col-md-4">
                                                <div class="perm-card">
                                                    <div class="perm-card-header">
                                                        {{ $permissionGroups[$groupKey] ?? ucfirst($groupKey) }}
                                                    </div>
                                                    <div class="perm-card-body">
                                                        @foreach($perms as $perm)
                                                            @php
                                                                $isInRole = in_array($perm->id, $rolePermissions);
                                                                $isDirect = !$isInRole && in_array($perm->id, $user_permissions);
                                                                $checked = $isInRole || $isDirect;
                                                            @endphp
                                                            <div class="perm-item">
                                                                <input type="checkbox"
                                                                       id="perm_{{$perm->id}}"
                                                                       value="{{ $perm->id }}"
                                                                       class="perm-checkbox"
                                                                    {{ $checked ? 'checked' : '' }}
                                                                    {{ $isInRole ? 'disabled' : '' }}>
                                                                <label for="perm_{{$perm->id}}"
                                                                       class="{{ $isInRole ? 'permission-through-role' : '' }}">
                                                                    {{ $perm->name_ar ?? $perm->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="text-center mt-4">
                                        <button type="button" id="savePermissions" class="btn btn-lg btn-success">
                                            <i class="fa fa-save"></i> Save Permissions
                                        </button>
                                    </div>
                                @endif
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
        $('#savePermissions').click(function () {
            var btn = $(this);
            btn.prop('disabled', true);
            btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...');

            var user_id = $('input[name="user_id"]').val();
            var permissions = [];
            $('.perm-checkbox:not(:disabled):checked').each(function () {
                permissions.push($(this).val());
            });

            $.ajax({
                url: '{{ route('admin.users.update_permissions') }}',
                type: 'POST',
                data: {
                    user_id: user_id,
                    permissions: permissions,
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    if (data.success) {
                        toastr.success(data.message);
                        setTimeout(function () {
                            window.location.reload();
                        }, 800);
                    } else {
                        toastr.error(data.message);
                        btn.prop('disabled', false);
                        btn.html('<i class="fa fa-save"></i> Save Permissions');
                    }
                },
                error: function () {
                    toastr.error('An error occurred.');
                    btn.prop('disabled', false);
                    btn.html('<i class="fa fa-save"></i> Save Permissions');
                }
            });
        });
    </script>
@endsection
