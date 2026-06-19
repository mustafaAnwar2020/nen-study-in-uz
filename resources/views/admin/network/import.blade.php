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

                            <div class="card-body p-0">

                                <div class="text-center m-2 border p-4" style="border-style: dotted !important;">
                                    <label>Download the template</label>
                                    <div>
                                        <a href="{{asset('/helpers/network-temp.xlsx')}}"
                                           class="btn btn-outline-dark btn-sm">Download</a>
                                    </div>
                                </div>

                                <form action="{{route('admin.network.import')}}" method="post" id="form"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="file">Excel File</label>
                                                    <input id="file" class="form-control" name="file" type="file" required>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="card-footer clearfix">
                                <button type="submit" form="form" class="btn btn-dark">Import</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


@endsection



