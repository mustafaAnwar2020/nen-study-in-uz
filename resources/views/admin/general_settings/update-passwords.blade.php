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
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <form action="{{route('admin.update-passwords')}}" method="post"
                                      enctype="multipart/form-data">
                                    <div class="modal-body">
                                        @csrf

                                        <input type="hidden" name="row_id" id="row_id"
                                               value="{{ request()->input('row_id') }}">
                                        <input type="hidden" name="model" id="model"
                                               value="{{ request()->input('model') }}">

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="model" class="col-form-label">
                                                        نوع الحساب
                                                    </label>
                                                    <input type="text" disabled name="model" id="model"
                                                           value="{{__('dashboard.accounts.'.request()->model)}}"
                                                           class="form-control">
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name" class="col-form-label">
                                                        اسم
                                                    </label>
                                                    <input type="text" disabled name="name" id="name"
                                                           value="{{request()->name}}"
                                                           class="form-control">
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="password" class="col-form-label">
                                                        كلمة المرور الجديدة
                                                    </label>
                                                    <input type="text" id="password" name="password"
                                                           class="form-control">
                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">تعديل</button>
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

