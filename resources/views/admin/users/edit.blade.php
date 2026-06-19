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
                                    <a href="{{ route('admin.users.permissions', $user->id) }}"
                                       class="btn btn-sm btn-info">
                                        <i class="fa fa-shield-alt"></i> Manage Permissions
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.users.update', $user->id) }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" id="name" required
                                                    value="{{ $user->name }}" class="form-control @error('name') is-invalid @enderror">
                                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" id="username" name="username"
                                                    value="{{ $user->username }}" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" id="email" name="email"
                                                    value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror">
                                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">New Password <small>(leave empty to keep current)</small></label>
                                                <input type="password" name="password" id="password"
                                                    class="form-control @error('password') is-invalid @enderror">
                                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="role_id">Role <span class="text-danger">*</span></label>
                                                <select name="role_id" id="role_id" class="form-control @error('role_id') is-invalid @enderror">
                                                    <option value="">Select Role</option>
                                                    @foreach ($roles as $role)
                                                        <option
                                                            {{ optional($user->roles()->first())->id == $role->id ? 'selected' : '' }}
                                                            value="{{ $role->id }}">{{ $role->name_ar ?? $role->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>

                                        @if ($user->address_city_id)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Governorate</label>
                                                    <select name="address_governorate_id" class="form-control"
                                                        onchange="getCities(this)">
                                                        <option selected disabled>Select Governorate</option>
                                                        @foreach (getGovernorates() as $governorate)
                                                            <option
                                                                {{ $user->address_governorate_id == $governorate->id ? 'selected' : '' }}
                                                                value="{{ $governorate->id }}">
                                                                {{ $governorate->governorate_name_ar }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <select class="form-control cities" name="address_city_id" id="cities">
                                                        <option disabled>Select City</option>
                                                        <option selected value="{{ $user->address_city_id }}">
                                                            {{ getCityById($user->address_city_id) }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endif

                                        @if (!$user->address_city_id)
                                            <div class="col-md-6">
                                                <div class="form-group select2-purple">
                                                    <label>Controlled Governorates <small>(for coordinators/managers)</small></label>
                                                    <select name="controlling_governorates[]" multiple
                                                        class="select2 form-control" data-placeholder="">
                                                        @foreach (getAllGovernorates() as $governorate)
                                                            <option
                                                                {{ $user->controllingGovernorates->contains($governorate->id) ? 'selected' : '' }}
                                                                value="{{ $governorate->id }}">
                                                                {{ $governorate->governorate_name_ar }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Assigned Events <small>(user can edit these specific events)</small></label>
                                                <select name="events[]" multiple class="form-control select2"
                                                        style="width: 100%;">
                                                    @foreach($events as $event)
                                                        <option value="{{ $event->id }}"
                                                            {{ in_array($event->id, $userEventIds) ? 'selected' : '' }}>
                                                            {{ $event->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-success">Save</button>
                                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>
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
        $(function () {
            $('.select2').select2({
                placeholder: 'Select events',
                allowClear: true
            });
        });

        function getCities(ele) {
            $.ajax({
                url: '/api/get/cities',
                type: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    governorate_id: ele.value,
                },
                success: (res) => {
                    $('#cities').html(`<option disabled selected>اختر</option>`);
                    for (let i = 0; i < res.length; i++) {
                        $('#cities').append(`<option value="${res[i].id}">${res[i].city_name_ar}</option>`);
                    }
                },
            });
        }
    </script>
@endsection
