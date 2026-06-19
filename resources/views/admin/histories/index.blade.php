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

                                <button class="btn btn-sm btn-info float-right" data-toggle="modal"
                                        data-target="#filter">
                                    <i class="fa fa-filter"></i>
                                </button>

                                @if(request()->type)
                                    <a class="float-right mt-1 mr-2" href="?">إلغاء الفلترة</a>
                                @endif

                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="dataTableRows table table-bordered table-hover">
                                    <thead class="bg-gradient-gray">
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th class="text-center">المستخدم</th>
                                        <th class="text-center">العملية</th>
                                        <th class="text-center">تمت علي</th>
                                        <th class="text-center">اسم</th>
                                        <th class="text-center">تاريخ ووقت</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($rows as $idx=>$row)
                                        <tr>
                                            <td>{{$idx+1}}</td>
                                            <td class="text-center">{{$row->getCreatedUserModelRowName()}}</td>
                                            <td class="text-center">
                                                <span class="badge badge-info">
                                                {{__('messages.'.$row->action)}}
                                            </span>
                                            </td>
                                            <td class="text-center">{{__('messages.models.'.$row->performed_on_model)}}</td>

                                            <td class="text-center">
                                                {{$row->getModelRowName()}}
                                            </td>

                                            <td class="text-center" dir="ltr">
                                                {{getDateTimeToView($row->created_at)}}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="6">لا توجد بيانات</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                <div class="card-footer clearfix">
                                    @include('includes.paginator', ['paginator'=>$rows->appends(request()->all())])
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('admin.histories.filter')


@endsection



