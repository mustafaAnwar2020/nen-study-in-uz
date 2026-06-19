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
                                <a href="{{route('admin.companies.create')}}" class="btn btn-sm btn-info mr-2 float-right">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0 table-responsive">
                                <table class="dataTableRows table table-bordered table-hover">
                                    <thead class="bg-gradient-gray">
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th class="text-center">اسم</th>
                                        <th class="text-center">صورة</th>
                                        <th class="text-center">البريد الإلكتروني</th>
                                        <th class="text-center">تاريخ الإضافة</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $idx=>$row)
                                        <tr>
                                            <td>{{$idx+1}}</td>
                                            <td class="text-center">{{$row->name }}</td>
                                            <td class="text-center">
                                                <img src="{{$row->image}}" width="50" alt="">
                                            </td>
                                            <td class="text-center">{{$row->email }}</td>
                                            <td class="text-center">{{$row->created_at->format('Y-m-d')}}</td>
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-info"
                                                   href="{{route('admin.companies.edit', $row->slug)}}">
                                                    <i class="fa fa-pen"></i>
                                                </a>
                                                <button
                                                        onclick="destroy('{{route('admin.companies.delete', $row->id)}}', '{{__('messages.sure_to_delete')}}')"
                                                        class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer clearfix">
                                @include('includes.paginator', ['paginator'=>$rows])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


@endsection

