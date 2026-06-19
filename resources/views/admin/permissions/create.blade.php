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
                                <form action="{{ route('admin.permissions.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" id="name" required
                                                       value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror"
                                                       placeholder="e.g. users.create">
                                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name_ar">Arabic Name</label>
                                                <input type="text" name="name_ar" id="name_ar"
                                                       value="{{ old('name_ar') }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="group">Group</label>
                                                <select name="group" id="group" class="form-control @error('group') is-invalid @enderror">
                                                    <option value="">Select Group</option>
                                                    @foreach($groups as $key => $label)
                                                        <option value="{{ $key }}" {{ old('group') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                                @error('group')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-success">Save</button>
                                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancel</a>
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
