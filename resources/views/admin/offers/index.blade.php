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
                                <button class="btn btn-sm btn-primary mr-2 float-right"
                                        data-toggle="modal" data-target="#filter" title="Filter"
                                >
                                    <i class="fa fa-filter"></i>
                                </button>

                                <a href="{{route('admin.offers.create')}}" class="btn btn-sm btn-dark mr-2 float-right">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0 table-responsive">
                                <table class="dataTableRows table table-bordered table-hover">
                                    <thead class="bg-gradient-gray">
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Country</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Special</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Date created</th>
                                        <th class="text-center">Special link</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $idx=>$row)
                                        <tr>
                                            <td>{{$idx+1}}</td>
                                            <td class="text-center">{{$row->name }}</td>
                                            <td class="text-center">
                                                {{ config('countries.'.$row->country_code)  }}
                                                <br>
                                                <span class="flag-icon flag-icon-{{$row->country_code}}"></span>
                                            </td>
                                            <td class="text-center">{{$row->date }}</td>
                                            <td class="text-center">
                                                @if(!empty($row->is_special))
                                                    <span class="badge badge-warning">Yes</span>
                                                @else
                                                    <span class="badge badge-secondary">—</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <img src="{{$row->getImage()}}" width="40" alt="">
                                            </td>
                                            <td class="text-center">{{$row->created_at->format('Y-m-d')}}</td>
                                            <td class="text-center text-nowrap">
                                                @if(!empty($row->is_special))
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-primary js-copy-special-offer-link"
                                                            data-url="{{ route('site.offers', ['special' => $row->slug]) }}"
                                                            title="Copy link (opens Offers page on this slide)">
                                                        <i class="fas fa-link"></i> Copy
                                                    </button>
                                                    <a href="{{ route('site.offers', ['special' => $row->slug]) }}"
                                                       target="_blank" rel="noopener"
                                                       class="btn btn-sm btn-outline-secondary"
                                                       title="Open">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{route('admin.offers.edit', $row->slug)}}"
                                                   class="btn btn-dark btn-sm">
                                                    <i class="fas fa-pen"></i>
                                                </a>
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

    @include('admin.offers.filter')


@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.js-copy-special-offer-link').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var url = this.getAttribute('data-url');
                if (!url) return;
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(url).then(function () {
                        if (typeof toastr !== 'undefined') {
                            toastr.success('Link copied to clipboard');
                        }
                    });
                }
            });
        });
    </script>
@endpush
