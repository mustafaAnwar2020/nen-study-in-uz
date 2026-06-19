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
                                <a href="{{route('admin.newsletter.export')}}"
                                   class="btn btn-sm btn-dark mr-2 float-right">
                                    Export
                                    <i class="fa fa-file-export"></i>
                                </a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0 table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Email</th>
                                        <th>Subscribed At</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $idx=>$row)
                                        <tr>
                                            <td>{{$idx+1}}</td>
                                            <td>{{$row->email }}</td>
                                            <td>{{$row->created_at }}</td>
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

