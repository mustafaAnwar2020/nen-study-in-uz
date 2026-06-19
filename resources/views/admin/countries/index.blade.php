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
                                
                                <a href="{{route('admin.countries.create')}}" class="btn btn-sm btn-dark mr-2 float-right">
                                    <i class="fa fa-plus"></i> Add Country
                                </a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- Search Form -->
                                <form method="GET" action="{{route('admin.countries.index')}}" class="mb-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" name="search" class="form-control" 
                                                   placeholder="Search by name or code..." 
                                                   value="{{request('search')}}">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-search"></i> Search
                                            </button>
                                        </div>
                                        @if(request('search'))
                                        <div class="col-md-2">
                                            <a href="{{route('admin.countries.index')}}" class="btn btn-secondary">
                                                <i class="fa fa-times"></i> Clear
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </form>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="bg-gradient-gray">
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Sort Order</th>
                                            <th class="text-center">Registration URL</th>
                                            <th class="text-center">Date Created</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($data as $idx=>$country)
                                            <tr>
                                                <td>{{$data->firstItem() + $idx}}</td>
                                                <td>
                                                    <span class="badge badge-secondary">{{strtoupper($country->code)}}</span>
                                                </td>
                                                <td>{{$country->name}}</td>
                                                <td class="text-center">
                                                    @if($country->is_active)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{$country->sort_order}}</td>
                                                <td class="text-center">
                                                    <a href="{{$country->registration_url}}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fa fa-external-link-alt"></i>
                                                    </a>
                                                </td>
                                                <td class="text-center">{{$country->created_at->format('Y-m-d')}}</td>
                                                <td class="text-center">
                                                    <a href="{{route('admin.countries.edit', $country->id)}}"
                                                       class="btn btn-dark btn-sm">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <form method="POST" action="{{route('admin.countries.destroy', $country->id)}}" 
                                                          style="display: inline-block;" 
                                                          onsubmit="return confirm('Are you sure you want to delete this country?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No countries found.</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                @if(method_exists($data, 'appends'))
                                    {{$data->appends(request()->all())->links()}}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection