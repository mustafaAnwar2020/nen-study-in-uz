@extends('admin.layouts.admin_dashboard', ['title' => $model])

@section('content')
    <div class="content-wrapper">
        @include('admin.layouts.breadcrumb', ['model' => $model])
        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $model }}</h3>
                                <a href="{{ route('admin.tpi-faqs.create') }}" class="btn btn-sm btn-dark float-right">
                                    <i class="fa fa-plus"></i> Add FAQ
                                </a>
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="bg-gradient-gray">
                                    <tr>
                                        <th style="width: 50px">#</th>
                                        <th>Question</th>
                                        <th style="width: 80px">Order</th>
                                        <th style="width: 80px">Active</th>
                                        <th style="width: 120px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $idx => $row)
                                        <tr>
                                            <td>{{ $idx + $rows->firstItem() }}</td>
                                            <td>{{ Str::limit($row->question, 60) }}</td>
                                            <td>{{ $row->sort_order }}</td>
                                            <td>{{ $row->is_active ? 'Yes' : 'No' }}</td>
                                            <td>
                                                <a href="{{ route('admin.tpi-faqs.edit', $row->id) }}" class="btn btn-dark btn-sm">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <form action="{{ route('admin.tpi-faqs.destroy', $row->id) }}" method="post" class="d-inline" onsubmit="return confirm('Delete this FAQ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                @include('includes.paginator', ['paginator' => $rows->appends(request()->all())])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
