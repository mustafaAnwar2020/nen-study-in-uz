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
                                <h3 class="card-title">{{ $model }}</h3>
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Event</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Received</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $idx => $row)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $row->event?->name ?? '—' }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->email }}</td>
                                            <td>{{ $row->phone }}</td>
                                            <td>
                                                <span class="badge badge-{{ $row->is_done ? 'success' : 'info' }}">
                                                    {{ $row->getStatus() }}
                                                </span>
                                            </td>
                                            <td>{{ $row->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <button
                                                    onclick="openEventRequestDetails('{{ json_encode($row) }}')"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye"></i>
                                                </button>

                                                @if(!$row->is_done)
                                                    <button
                                                        onclick="destroy('{{ route('admin.event-requests.mark-done', $row->id) }}', 'Mark as handled?')"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fa fa-check-circle"></i>
                                                    </button>
                                                @endif

                                                <button
                                                    onclick="destroy('{{ route('admin.event-requests.delete', $row->id) }}', '{{ __('Sure to delete this request?') }}')"
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
        function openEventRequestDetails(content) {
            var parsedData = JSON.parse(content);

            var data = `
                <table class="table">
                    <tbody>
                        <tr><th>Event</th><td>${parsedData.event ? parsedData.event.name : '—'}</td></tr>
                        <tr><th>Name</th><td>${parsedData.name || ''}</td></tr>
                        <tr><th>Email</th><td>${parsedData.email || ''}</td></tr>
                        <tr><th>Phone</th><td>${parsedData.phone || ''}</td></tr>
                        <tr><th>Received</th><td>${parsedData.created_at || ''}</td></tr>
                    </tbody>
                </table>
                <hr>
                <h6>Notes</h6>
                <p>${parsedData.notes || '—'}</p>`;

            $('#content').html(data);
            $('#fullDetails').modal('show');
        }
    </script>
@endpush
