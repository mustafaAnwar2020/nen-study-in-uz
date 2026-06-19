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
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.users.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label">Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" id="name" required
                                                       value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
                                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="username" class="col-form-label">Username <span class="text-danger">*</span></label>
                                                <input type="text" name="username" id="username" required
                                                       value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror">
                                                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="col-form-label">Email</label>
                                                <input type="email" name="email" id="email"
                                                       value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
                                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password" class="col-form-label">Password <span class="text-danger">*</span></label>
                                                <input type="password" name="password" id="password" required
                                                       class="form-control @error('password') is-invalid @enderror">
                                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="role_id" class="col-form-label">Role <span class="text-danger">*</span></label>
                                                <select name="role_id" id="role_id" class="form-control @error('role_id') is-invalid @enderror">
                                                    <option value="">Select Role</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                            {{ $role->name_ar ?? $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-success">Save</button>
                                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
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
