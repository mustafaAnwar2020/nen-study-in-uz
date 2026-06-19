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
                                <h3 class="card-title"> {{ $model }} </h3>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('admin.users.store') }}" method="post">
                                    @csrf
                                    <div class="row">


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="role" class="col-form-label">
                                                    الدور
                                                </label>
                                                <select id="role" name="role" class="form-control"
                                                        onchange="onSelectUserRole(this)">
                                                    <option selected disabled>إختر</option>
                                                    @foreach (getAppRoles() as $role)
                                                        @if ($role->name != 'student' && $role->name != 'instructor')
                                                            <option data-name="{{ $role->name }}"
                                                                    value="{{ $role->id }}">
                                                                {{ $role->name_ar }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label">
                                                    الإسم
                                                </label>
                                                <input type="text" name="name" id="name" required
                                                       class="form-control" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label">
                                                    الايميل
                                                    <small>اختياري</small>
                                                </label>
                                                <input type="text" name="email" id="email" class="form-control"
                                                       readonly>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-sm btn-success">حفظ</button>
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
