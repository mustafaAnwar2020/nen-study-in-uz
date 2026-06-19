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
                                <form action="{{route('admin.companies.store')}}" method="post" id="form"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="row_id" value="{{isset($row) ? $row->id : ''}}">

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">اسم</label>
                                                    <input id="name" class="form-control" name="name"
                                                           value="{{isset($row) ? $row->name : old('name')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">البريد الإلكتروني</label>
                                                    <input id="email" class="form-control" name="email" type="email"
                                                           value="{{isset($row) ? $row->email : old('email')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phone">رقم الهاتف</label>
                                                    <input id="phone" class="form-control" name="phone" type="text"
                                                           value="{{isset($row) ? $row->phone : old('phone')}}">
                                                </div>
                                            </div>

                                            @if(!isset($row))
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">كلمة المرور</label>
                                                        <input id="password" class="form-control" name="password"
                                                               type="text">
                                                    </div>
                                                </div>
                                            @endif


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="image">
                                                        الملف
                                                        @if(isset($row) && $row->image)
                                                            <a href="{{$row->image}}" target="_blank">
                                                                عرض
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endif

                                                    </label>
                                                    <x-file-upload class="form-control" data-folder="providers"
                                                                   name="image-file"/>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </form>
                            </div>

                            <div class="card-footer clearfix">
                                <button type="submit" form="form" class="btn btn-success">حفظ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


@endsection



