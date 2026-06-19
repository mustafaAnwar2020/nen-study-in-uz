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
                                <button class="btn btn-sm btn-success float-right" onclick="addNew()"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0 table-responsive">
                                <table class="dataTableRows table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('admin_dashboard.common.title')}}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $idx=>$row)
                                        <tr>
                                            <td>{{$idx+1}}</td>
                                            <td>{{$row-> {'title_'.app()->getLocale()} }}</td>
                                            <td>
                                                <button
                                                    onclick="showSections({{$row->id}},'{{$row->{'title_'.app()->getLocale()} }}', this)"
                                                    class="btn btn-info btn-sm">
                                                    {{__('admin_dashboard.pages.show sections')}}
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

    @include('admin.pages.sections_modal')

@endsection

@section('scripts')

    <script>
        function showSections(id, title, ele) {
            $(ele).html(`<span class="fa fa-spinner"></span> `);
            $('input[name="row_id"]').val(id);
            $.ajax({
                url: '{{route('admin.pages.index')}}' + '/' + id,
                type: 'get',
                data: {_token: "{{csrf_token()}}"},
                success: (res) => {
                    $('#sections').html(``);
                    $(ele).html('{{__('admin_dashboard.pages.show sections')}}');
                    for (let i = 0; i < res.length; i++) {
                        $('#sections').append(
                            `
                            <tr>
                                <td>${res[i].title}</td>
                                <td><a href="{{route('admin.pages.index')}}/sections/${res[i].id}" class="btn btn-info">{{__('admin_dashboard.common.edit')}}</a></td>
                            </tr>
                            `
                        );
                    }
                    $('.modal-title').html(title);
                    $('#showSections').modal('show');
                },
            });
        }

        function addNew() {
            $('form#addNewForm').trigger("reset");
            $('input[name="tag_id"]').val('');
            $('.modal-title').html("{{__('admin_dashboard.common.add new')}}");
            $('.modal-footer').find('button').html("{{__('admin_dashboard.common.save')}}");
            $('#addNewModal').modal('show');
        }
    </script>

@endsection
