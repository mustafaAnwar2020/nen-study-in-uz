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
                                <button class="btn btn-sm btn-primary mr-2 float-right" data-toggle="modal"
                                    data-target="#filter" title="Filter">
                                    <i class="fa fa-filter"></i>
                                </button>

                                <a href="{{ route('admin.faqs.create') }}" class="btn btn-sm btn-dark mr-2 float-right">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0 table-responsive">
                                <table class="dataTableRows table table-bordered table-hover">
                                    <thead class="bg-gradient-gray">
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th class="text-center">Question</th>
                                            <th class="text-center">Product type</th>
                                            <th class="text-center">Show on home</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Date created</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rows as $idx => $row)
                                            <tr>
                                                <td>{{ $idx + 1 }}</td>
                                                <td class="text-center">{{ $row->name }}</td>
                                                <td class="text-center">{{ $row->product_type_label }}</td>
                                                <td class="text-center">
                                                    @if($row->show_in_home)
                                                        <i class="fas fa-check text-success"></i>
                                                    @else
                                                        <i class="fas fa-minus text-muted"></i>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <img src="{{ $row->getImage() }}" width="40" alt="">
                                                </td>
                                                <td class="text-center">{{ $row->created_at->format('Y-m-d') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.faqs.edit', $row->slug) }}"
                                                        class="btn btn-dark btn-sm">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <form action="{{ route('admin.faqs.delete', $row->id) }}"
                                                        method="post" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                @include('includes.paginator', [
                                    'paginator' => $rows->appends(request()->all()),
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('admin.faqs.filter')
@endsection
