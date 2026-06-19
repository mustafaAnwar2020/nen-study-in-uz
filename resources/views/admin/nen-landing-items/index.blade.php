@extends('admin.layouts.admin_dashboard', ['title' => $model])

@section('content')
<div class="content-wrapper">
    @include('admin.layouts.breadcrumb', ['model' => $model])
    <section class="content">
        <div class="container-fluid">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $model }}</h3>
                    <a href="{{ route('admin.nen-landing-items.create', $resource) }}" class="btn btn-sm btn-dark float-right"><i class="fa fa-plus"></i> Add</a>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="bg-gradient-gray"><tr><th>#</th><th>Title</th><th>Order</th><th>Active</th><th></th></tr></thead>
                        <tbody>
                        @foreach($rows as $idx => $row)
                            <tr>
                                <td>{{ $idx + $rows->firstItem() }}</td>
                                <td>{{ $row->name ?? $row->title ?? $row->question ?? $row->caption ?? '-' }}</td>
                                <td>{{ $row->sort_order }}</td>
                                <td>{{ $row->is_active ? 'Yes' : 'No' }}</td>
                                <td>
                                    <a href="{{ route('admin.nen-landing-items.edit', [$resource, $row->id]) }}" class="btn btn-dark btn-sm"><i class="fas fa-pen"></i></a>
                                    <form action="{{ route('admin.nen-landing-items.destroy', [$resource, $row->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Delete?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">@include('includes.paginator', ['paginator' => $rows->appends(request()->all())])</div>
            </div>
        </div>
    </section>
</div>
@endsection
