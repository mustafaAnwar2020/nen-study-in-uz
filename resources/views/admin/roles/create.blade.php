@extends('admin.layouts.admin_dashboard', ['title' => $model])

@section('styles')
    <style>
        .permission-group { border: 1px solid #dee2e6; border-radius: 4px; margin-bottom: 15px; }
        .permission-group-header { background: #f4f6f9; padding: 10px 15px; border-bottom: 1px solid #dee2e6; font-weight: bold; }
        .permission-group-body { padding: 10px 15px; }
        .permission-group-body .checkbox-item { margin-bottom: 8px; }
        .permission-group-body .checkbox-item label { margin-right: 5px; cursor: pointer; }
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
                                <h3 class="card-title">{{ $model }}</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.roles.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" id="name" required
                                                       value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
                                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name_ar">Arabic Name</label>
                                                <input type="text" name="name_ar" id="name_ar"
                                                       value="{{ old('name_ar') }}" class="form-control @error('name_ar') is-invalid @enderror">
                                                @error('name_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" rows="2"
                                                          class="form-control">{{ old('description') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <h5>Role Permissions</h5>
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <div class="form-check">
                                                <input type="checkbox" id="selectAll" class="form-check-input">
                                                <label for="selectAll" class="form-check-label font-weight-bold">Select All</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @forelse($permissionGroups as $groupKey => $group)
                                            <div class="col-md-4">
                                                <div class="permission-group">
                                                    <div class="permission-group-header">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input group-selector" id="group_{{$groupKey}}" data-group="{{ $groupKey }}">
                                                            <label for="group_{{$groupKey}}" class="form-check-label">{{ $group['label'] }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="permission-group-body">
                                                        @foreach($group['permissions'] as $perm)
                                                            <div class="checkbox-item">
                                                                <input type="checkbox" name="permissions[]"
                                                                       value="{{ $perm->id }}"
                                                                       id="perm_{{$perm->id}}"
                                                                       class="perm-checkbox group-{{ $groupKey }}"
                                                                       {{ in_array($perm->id, old('permissions', [])) ? 'checked' : '' }}>
                                                                <label for="perm_{{$perm->id}}">{{ $perm->name_ar ?? $perm->name }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-md-12">
                                                <div class="alert alert-info">No permissions found. Please sync default permissions first.</div>
                                            </div>
                                        @endforelse
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-success">Save</button>
                                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
                                        </div>
                                    </div>
                                </form>
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
        $('#selectAll').on('change', function () {
            $('.perm-checkbox').prop('checked', $(this).prop('checked'));
            $('.group-selector').prop('checked', $(this).prop('checked'));
        });

        $('.group-selector').on('change', function () {
            var group = $(this).data('group');
            $('.group-' + group).prop('checked', $(this).prop('checked'));
            updateSelectAll();
        });

        $('.perm-checkbox').on('change', function () {
            updateSelectAll();
            var group = $(this).attr('class').match(/group-(\S+)/);
            if (group) {
                var groupKey = group[1];
                var $groupCheckboxes = $('.group-' + groupKey);
                var $groupSelector = $('#group_' + groupKey);
                $groupSelector.prop('checked', $groupCheckboxes.length === $groupCheckboxes.filter(':checked').length);
            }
        });

        function updateSelectAll() {
            var total = $('.perm-checkbox').length;
            var checked = $('.perm-checkbox:checked').length;
            $('#selectAll').prop('checked', total === checked);
        }
    </script>
@endsection
