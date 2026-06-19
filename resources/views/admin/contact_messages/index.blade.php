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
                            <!-- /.card-header -->
                            <div class="card-body p-0 table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $idx=>$row)
                                        <tr>
                                            <td>{{$idx+1}}</td>
                                            <td>{{$row->name }}</td>
                                            <td>{{$row->email }}</td>
                                            <td>{{$row->phone }}</td>

                                            <td>
                                                <span class="badge badge-info">
                                                    {{$row->getStatus()}}
                                                </span>
                                            </td>

                                            <td>
                                                <button
                                                        onclick="openFullDetails('{{json_encode($row)}}')"
                                                        class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye"></i>
                                                </button>


                                                @if(!$row->is_done)
                                                    <button
                                                            onclick="destroy('{{route('admin.contact-messages.mark-done', $row->id)}}', 'Mark as contacted?')"
                                                            class="btn btn-success btn-sm">
                                                        <i class="fa fa-check-circle"></i>
                                                    </button>
                                                @endif


                                                <button
                                                        onclick="destroy('{{route('admin.contact-messages.delete', $row->id)}}', '{{__('Sure to delete this message?')}}')"
                                                        class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
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

    @include('includes.showDetails')

@endsection

@push('scripts')
    <script>
        function openFullDetails(content) {
            let parsedData = JSON.parse(content);


            let data = `

    <table class="table">
        <thead>
        <tr>
            <th>اسم</th>
            <th>الهاتف</th>
            <th>الايميل</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>${parsedData.name}</td>
            <td>${parsedData.phone}</td>
            <td>${parsedData.email}</td>
        </tr>


        </tbody>
    </table>
<hr>

<h6>محتوي الرسالة</h6>
             <p>${parsedData.message}</p>`;

            $('#content').html(data);
            $('#fullDetails').modal('show');
        }

    </script>
@endpush


